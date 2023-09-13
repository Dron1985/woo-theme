<?php

/**
 * Check data and return markup if data not empty
 *
 * @param string $prefix
 *  String markup prefix.
 * @param mixed $data
 *  Array with data.
 * @param string $field_name
 *  Field name in data
 * @param string $suffix
 * @param string $type
 * <pre>
 *  text     - default text;
 *  img      - image tag with src and alt;
 *  bg_img   - bg image with style bg src
 *             prefix will be a tag;
 *  url      - url without link title;
 *  link     - url with link title;
 *  mail     - url with mailto: href and mail link title;
 *  tel      - url with tel: href and tel link title;
 *  form     - id for contact form;
 * </pre>
 * @param string|array $attributes
 *  I`ts can be like string of class like 'class_name' and as additional option
 *  you can add array ['class' => ['class1', 'class2'], 'style' => ['color: #fff']];
 *  it will be transform to string.
 *
 * @param string $text_after_link
 * @param boolean $echo
 *
 * @return string Return markup string
 */
function render(string $prefix = '', $data, string $field_name, string $suffix = '', string $type = 'text', $attributes = '', $text_before_link = '', $text_after_link = '', $echo = TRUE) {
  $markup = '';
  if ($data && isset($data[$field_name]) && !empty($data[$field_name])) {
    if ($type != 'bg_img') {
      $markup .= $prefix;
    }
    if (is_string($attributes)) {
      $attributes = render_attributes(['class' => [$attributes]], FALSE);
    }
    else {
      $attributes = render_attributes($attributes, FALSE);
    }
    $field = $data[$field_name];
    switch ($type) {
      case 'text':
        $markup .= $field;
        break;
      case 'img':
        $markup .= '<img src="' . $field['url'] . '" alt="' . $field['alt'] . '" ' . $attributes . '>';
        break;
      case 'bg_img':
        $bg = !empty($field['url']) ? 'style="background-image: url(' . $field['url'] . ')"' : '';
        $markup .= '<' . $prefix . ' ' . $bg . ' ' . $attributes . '></' . $prefix . '>';
        break;
      case 'url':
        $markup .= '<a href="' . $field . '" ' . $attributes . '>' . $text_before_link . '</a>';
        break;
      case 'url_blank':
        $markup .= '<a href="' . $field . '" ' . $attributes . ' target="_blank">' . $text_before_link . '</a>';
        break;
      case 'mail':
        $markup .= '<a href="mailto:' . $field . '" ' . $attributes . '>' . $text_before_link . $field . $text_after_link . '</a>';
        break;
      case 'tel':
        $markup .= '<a href="' . phone_url($field) . '" ' . $attributes . '>' . $text_before_link . $field . $text_after_link . '</a>';
        break;
      case 'link':
        $markup .= render_ACF_Link($field, $attributes, '', $text_before_link, $text_after_link);
        break;
      case 'anchor_link':
        $anchor = $field['anchor'] ?? '';
        $title = $field['title'] ?? '';
        $markup .= '<a href="#"' . $attributes . 'data-goto-anchor="table-section" data-value="' . $anchor . '">' . $text_before_link . $title . $text_after_link . '</a>';
        break;
      case 'data_link':
        $anchor = $field['anchor'] ?? '';
        $title = $field['title'] ?? '';
        $markup .= '<a href="#"' . $attributes . ' data-value="' . $anchor . '">' . $text_before_link . $title . $text_after_link . '</a>';
        break;
      case 'form':
        $markup .= '[ id="' . $field . '"]';
        break;
    }
    if ($type != 'bg_img') {
      $markup .= $suffix;
    }
    if ($echo) {
      echo $markup;
    }
    else {
      return $markup;
    }
  }
}

/**
 * Check data and return markup if data not empty
 *
 * @param string $prefix
 *  String markup prefix.
 * @param mixed $data
 *  Array with data.
 * @param string $field_name
 *  Field name in data
 */
function render_image(string $prefix = '', $data, string $field_name = '', string $suffix = '', string $size = 'large', $class = '', $echo = TRUE) {
  $markup = '';
  if (!empty($field_name) && isset($data[$field_name]) && !empty($field_name)) {
    $field = $data[$field_name];
  }
  elseif (empty($field_name)) {
    $field = $data;
  }

  if (isset($field['sizes']) && isset($field['sizes'][$size])) {
    $markup .= $prefix;
    $markup .= '<img src="' . $field['sizes'][$size] . '" alt="' . $field['alt'] . '" ' . get_classes($class) . '>';
    $markup .= $suffix;
  }
  elseif (isset($field["src"])) {
    $markup .= $prefix;
    $markup .= '<img src="' . $field["src"] . '" alt="' . $field['alt'] . '" ' . get_classes($class) . '>';
    $markup .= $suffix;
  }
  if ($echo) {
    echo $markup;
  }
  else {
    return $markup;
  }
}

/**
 * Get class string.
 *
 * @param $class
 *
 * @return string
 */
function get_classes($class): string {
  return !empty($class) ? 'class="' . $class . '"' : '';
}


/**
 * Get image src from data
 *
 * @param $data
 * @param string $field_name
 * @param $echo
 *
 * @return mixed|void
 */
function get_img_src($data, string $field_name = '', $echo = TRUE) {
  $src = '';
  if (!empty($field_name) && isset($data[$field_name]) && !empty($field_name)) {
    $data = $data[$field_name];
  }
  $src = $data['url'];
  if ($echo) {
    echo $src;
  }
  else {
    return $src;
  }
}

/**
 * Check if not empty values.
 * Work as empty().
 *
 * @param mixed $data
 *  Array data.
 * @param array $fields
 *  List of fields to be checked
 * @param bool $hard_chek
 *  Method of compare false => 'or', true => 'and'
 *
 * @return bool
 */
function is_empty($data, array $fields, $hard_chek = FALSE): bool {
  $result = FALSE;
  if ($data) {
    foreach ($fields as $field) {
      if (isset($data[$field]) && !empty($data[$field])) {
        if (!$hard_chek) {
          return TRUE;
        }
        else {
          $result = TRUE;
        }
      }
      elseif ($hard_chek) {
        return FALSE;
      }
    }
  }

  return !$result;
}

/**
 * @param array $attributes
 * @param $echo
 *
 * @return string|void
 */
function render_attributes(array $attributes, $echo = TRUE) {
  $string = '';
  foreach ($attributes as $name => $attribute) {
    if ($attribute && $attribute = (array) $attribute) {
      $string .= ' ';
      $string .= $name . '="' . implode(' ', $attribute) . '"';
    }
  }
  if ($echo) {
    echo $string;
  }
  else {
    return $string;
  }
}

/**
 * Get src for Remote Video.
 *
 * @param $field
 *
 * @return mixed
 */
function get_src_for_remote($src) {
  $is_vimeo = FALSE;
  $embed_url = '';
  $video_key = '';
  if (strpos($src, 'youtube.com/watch')) {
    $src_components = parse_url($src);
    parse_str($src_components['query'], $get_params);
    if (isset($get_params['v'])) {
      $video_key = $get_params['v'];
    }
  }
  elseif (strpos($src, 'youtube.com/embed')) {
    $video_key = preg_replace('/(http)?(s)?(:\/\/)?(www\.)?youtube\.com\/embed\//', '', $src);
  }
  elseif (strpos($src, 'youtu.be')) {
    $video_key = preg_replace('/(http)?(s)?(:\/\/)?(www\.)?youtu.be\//', '', $src);
  }
  elseif (strpos($src, 'vimeo')) {
    $is_vimeo = TRUE;
    $video_key = preg_replace('/(http)?(s)?(:\/\/)?(www\.)?vimeo.com\//', '', $src);
  }
  else {
    $embed_url = $src;
  }
  if ($video_key) {
    if (!$is_vimeo) {
      $embed_url = 'https://www.youtube.com/embed/' . $video_key;
    }
    else {
      $embed_url = 'https://player.vimeo.com/video/' . $video_key;
    }
  }

  return $embed_url;
}

/**
 * Generate video url from media and remote url;
 *
 * @param $data
 *
 * @return mixed|string
 */
function generate_video_url($data) {
  $video_url = '';
  if (isset($data['video_type']) && $data['video_type'] == 'media' && !empty($data['video'])) {
    $video_url = $data['video']['url'];
  }
  elseif (isset($data['video_type']) && $data['video_type'] == 'remote' && !empty($data['remote_video'])) {
    $video_url = get_src_for_remote($data['remote_video']);
  }

  return $video_url;
}

/**
 * Generate html from ACF field link
 *
 */
function render_ACF_Link($field, $attributes = '', $title_wrap = '', $text_before_link = '', $text_after_link = '') {
  $link_html = '';
  $url = isset($field['url']) && !empty($field['url']) ? $field['url'] : '';
  $title = isset($field['title']) && !empty($field['title']) ? html_entity_decode($field['title']) : '';
  $target_html = isset($field['target']) && $field['target'] == '_blank' ? 'target="_blank"' : '';
  $title = !empty($title_wrap) ? '<' . $title_wrap . '>' . $title . '</' . $title_wrap . '>' : $title;
  if (!empty($url)) {
    $link_html = '<a href="' . esc_url($url) . '" ' . $target_html . ' ' . $attributes . '>' . $text_before_link . $title . $text_after_link . '</a>';
  }
  return $link_html;
}

/**
 * Render feature image for content.
 */
function render_featured_image($prefix = '', $suffix = '', $size = 'large', $class = '', $echo = TRUE) {
  $markup = '';
  $image = get_featured_img_info($size);
  $markup .= render_image($prefix, $image, '', $suffix, $size, $class, FALSE);
  if ($echo) {
    echo $markup;
  }
  else {
    return $markup;
  }
}

/**
 * Get template as a string for svg icon
 */
function load_template_part($template_name, $part_name = NULL) {
  ob_start();
  get_template_part($template_name, $part_name);
  $var = ob_get_contents();
  ob_end_clean();
  return $var;
}

/**
 * Check is key exists.
 *
 * @param array $parents
 *      An array of parent keys of the value, starting with the outermost key.
 */
function array_has_key(array $array, array $parents, $check_is_empty = FALSE): bool {
    $ref = &$array;
    foreach ($parents as $parent) {
        if (is_array($ref) && array_key_exists($parent, $ref)) {
            $ref = &$ref[$parent];
        }
        else {
            return FALSE;
        }
    }
    return $check_is_empty ? !empty($ref) : TRUE;
}

/**
 * Retrieves a value from a nested array with variable depth.
 *
 * @param array $array
 *      The array from which to get the value.
 * @param array $parents
 *      An array of parent keys of the value, starting with the outermost key.
 * @param null $default_value
 *      If key not exists the function will return this value.
 * @return array|mixed|null
 *      The requested nested value.
 */
function array_get_value(array $array, array $parents, $default_value = NULL) {
    $ref = &$array;
    foreach ($parents as $parent) {
        if (is_array($ref) && array_key_exists($parent, $ref)) {
            $ref = &$ref[$parent];
        }
        else {
            return $default_value;
        }
    }
    return $ref;
}

/**
 * Get SVG file content to string.
 */
function get_svg_file_content($file_field) : string {
    $svg_file = '';
    if (array_has_key($file_field, ['mime_type'], TRUE)) {
        if ($file_field['mime_type'] === 'image/svg+xml') {
            $file = get_attached_file($file_field['id'], TRUE);
            $svg_file = file_get_contents($file);
        }
    }
    return $svg_file;
}
