@isset($pageElement)
  <?php
  $template = $pageElement['element']['template'];
  $template = str_replace('{{cstm_class}}', $pageElement->e_class, $template);
  $template = str_replace('{{cstm_id}}', $pageElement->e_id, $template);
  foreach ($pageElement['content'] as $content) {
    $template = str_replace('{{' . $content['field']['slug'] . '}}', $content['content'], $template);
    $template = str_replace('src="/', 'src="' . asset(''), $template);
  }
  $children = $pageElement->child_page_element(explode(',', $pageElement->children_ids));
  if ($pageElement->element->type == 'parent') {
    $chldCont = '';
    if ($children->isNotEmpty()) {
      foreach ($children as $child) {
        $childTemplate = $child['element']['template'];
        $childTemplate = str_replace('{{cstm_class}}', $child->e_class, $childTemplate);
        $childTemplate = str_replace('{{cstm_id}}', $child->e_id, $childTemplate);
        foreach ($child['content'] as $childContent) {
          $childTemplate = str_replace('{{' . $childContent['field']['slug'] . '}}', $childContent['content'], $childTemplate);
          $childTemplate = str_replace('src="/', 'src="' . asset(''), $childTemplate);
        }
        $chldCont .= $childTemplate;
      }
    }
    $template = str_replace('{{section_loop}}', $chldCont, $template);
  }
  $pageContent .= $template;
  echo $pageContent;
  ?>
@endisset