<?php
if (!defined('Execute')) {
  exit();
}

class Pagination
{
  // 总数据量
  private $total = 0;
  // 当前页
  private $pageIndex = 1;
  // 分页大小
  private $pageSize = 0;
  // 页数
  private $pageCount = 0;
  // 显示页数
  public $pagerCount = 10;
  // 候选页码
  private $pageSizes = [5, 10, 20, 30, 40];

  private $querys = [];

  public $prevText = '上一页';
  public $nextText = '下一页';

  private $queryPageIndexField = 'pageIndex';
  private $queryPageSizeField = 'pageSize';

  public $hasPrevMore = false;
  public $hasNextMore = false;

  public $containerClassName = '';

  function __construct($total, $pageIndex = 1, $pageSize = 20)
  {
    $this->total = intval($total);
    $this->pageIndex = intval($pageIndex);
    $this->pageSize = intval($pageSize);
    $this->init();
  }

  function array2Query($arr)
  {
    $keys = [];
    foreach ($arr as $key => $val) {
      array_push($keys, $key . '=' . $val);
    }

    return implode('&', $keys);
  }

  /**
   * 修改分页输出参数的名称
   */
  function setQueryField($arr = [])
  {
    if (array_key_exists('page', $arr) && $arr['page']) {
      $this->queryPageIndexField = $arr['page'];
    }

    if (array_key_exists('size', $arr) && $arr['size']) {
      $this->queryPageSizeField = $arr['size'];
    }
  }

  /**
   * 添加分页传递的参数
   */
  function setQueryParams($querys)
  {
    if (is_array($querys)) {
      foreach ($querys as $key => $val) {
        $this->querys[$key] = $val;
      }
    }

    return $this->querys;
  }

  /**
   * 初始化
   */
  private function init()
  {
    $this->pageCount = intval(ceil($this->total / $this->pageSize));

    if ($this->pageIndex > $this->pageCount) {
      $this->pageIndex = $this->pageCount;
    }
  }

  // 计算分页页码
  private function pager()
  {
    $pagerCount = $this->pagerCount;
    $pageCount = $this->pageCount;
    $currentPage = $this->pageIndex;

    $halfPagerCount = intval(floor(($pagerCount - 1) / 2));

    $showPrevMore = false;
    $showNextMore = false;


    if ($pageCount > $pagerCount) {
      if ($currentPage > $pagerCount - $halfPagerCount) {
        $showPrevMore = true;
      }
      if ($currentPage < $pageCount - $halfPagerCount) {
        $showNextMore = true;
      }
    }

    $pagers = [];

    if ($showPrevMore && !$showNextMore) {
      $startPage = $pageCount - ($pagerCount - 2);
      for ($i = $startPage; $i < $pageCount; $i++) {
        array_push($pagers, intval($i));
      }
    } else if (!$showPrevMore && $showNextMore) {
      for ($i = 2; $i < $pagerCount; $i++) {
        array_push($pagers, intval($i));
      }
    } else if ($showPrevMore && $showNextMore) {
      $offset = floor($pagerCount / 2) - 1;
      for ($i = $currentPage - $offset; $i <= $currentPage + $offset; $i++) {
        array_push($pagers, intval($i));
      }
    } else {
      for ($i = 2; $i < $pageCount; $i++) {
        array_push($pagers, intval($i));
      }
    }

    $this->hasPrevMore = $showPrevMore;
    $this->hasNextMore = $showNextMore;

    return $pagers;
  }

  function linkUrl($page)
  {
    $queryString = $this->array2Query($this->querys);

    $params = [
      $this->queryPageIndexField . '=' . $page,
      $this->queryPageSizeField . '=' . $this->pageSize
    ];

    $url =  '?' . join('&', $params) . ($queryString ? '&' . $queryString : '');

    return $url;
  }

  function link($page, $text = null)
  {
    $url = $this->linkUrl($page);

    return '<a href="' . $url . '">' . ($text ? $text : $page) . '</a>';
  }

  // 页码部分html
  private function pagerHTML()
  {
    $pagers = $this->pager();
    $htmls = ['<ul class="m-pager">'];
    $pagerCountOffset = $this->pagerCount - 2;

    if ($this->pageCount > 0) {
      array_push($htmls, '<li class="m-pager-number' . ($this->pageIndex === 1 ? ' active' : '') . '">' . $this->link('1') . '</li>');
    }

    if ($this->hasPrevMore) {
      array_push($htmls, '<li class="m-pager-number">' . $this->link($this->pageIndex - $pagerCountOffset, '&laquo;') . '</li>');
    }

    $len = count($pagers);

    for ($i = 0; $i < $len; $i++) {
      array_push($htmls, '<li class="m-pager-number' . ($this->pageIndex === $pagers[$i] ? ' active' : '') . '">' . $this->link($pagers[$i]) . '</li>');
    }

    if ($this->hasNextMore) {
      array_push($htmls, '<li class="m-pager-number">' . $this->link($this->pageIndex + $pagerCountOffset, '&raquo;') . '</li>');
    }

    if ($this->pageCount > 1) {
      array_push($htmls, '<li class="m-pager-number' . ($this->pageIndex === $this->pageCount ? ' active' : '') . '">' . $this->link($this->pageCount) . '</li>');
    }

    array_push($htmls, '</ul>');
    return join('', $htmls);
  }

  private function sizesHTML()
  {
    $action = '?' . $this->array2Query($this->querys) . '&' . $this->queryPageIndexField . '=1';

    $handlerChangeScript = "(function (e) {location.href='" . $action . "' + '&" . $this->queryPageSizeField . "=' + e.value;})(this)";

    $htmls = [
      '<select class="m-pagination-sizes" name="' . $this->queryPageSizeField . '" onchange="' . $handlerChangeScript . '">'
    ];

    $len = count($this->pageSizes);

    for ($i = 0; $i < $len; $i++) {
      array_push($htmls, '<option value="' . $this->pageSizes[$i] . '"' . ($this->pageSize == $this->pageSizes[$i] ? 'selected="selected"' : '') . '>' . $this->pageSizes[$i] . ' 条/页</option>');
    }

    array_push($htmls, '</select>');

    return join('', $htmls);
  }

  private function prevHTML()
  {
    $page = $this->pageIndex - 1;
    $page = $this->pageIndex < 1 ? 1 : $page;

    return '<span class="m-pagination-prev' . ($this->pageIndex === 1 ? ' disabled' : '') . '">' . $this->link($page, $this->prevText) . '</span>';
  }

  private function nextHTML()
  {
    $page = $this->pageIndex + 1;
    $page = $page > $this->pageCount ? $this->pageCount : $page;

    return '<span class="m-pagination-next' . ($this->pageIndex === $this->pageCount ? ' disabled' : '') . '">' . $this->link($page, $this->nextText) . '</span>';
  }

  // 输出分页
  function links($layouts = ['total', 'sizes', 'prev', 'pager', 'next'])
  {
    $layoutMap = [
      'total' => '<span class="m-pagination-total">共' . $this->total . '条</span>',
      'sizes' => $this->sizesHTML(),
      'prev' => $this->prevHTML(),
      'pager' => $this->pagerHTML(),
      'next' => $this->nextHTML()
    ];

    $htmls = ['<div class="m-pagination is-background' . ($this->containerClassName ? ' ' . $this->containerClassName : '') . '">'];

    if (!is_array($layouts)) {
      throw new Exception('One params must be an Array.');
    }

    $len = count($layouts);

    for ($i = 0; $i < $len; $i++) {
      array_push($htmls, ($layoutMap[$layouts[$i]] ? $layoutMap[$layouts[$i]] : $layouts[$i]));
    }

    array_push($htmls, '</div>');

    return join('', $htmls);
  }

  // 简单分页
  function simpleLinks()
  {
    return $this->links(['prev', 'next']);
  }

  function getPageData()
  {
    $data = [
      'total' => $this->total,
      'pageIndex' => $this->pageIndex,
      'pageSize' => $this->pageSize,
      'pageCount' => $this->pageCount
    ];

    return $data;
  }
}
