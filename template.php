<?php

require __DIR__ . '/vendor/autoload.php';

/**
 * Template Builder Component with Pug
 *
 */


class PugTemplate extends \Kirby\Component\Template {
  public $extension = 'pug';
  /**
   * Returns a template file path by name
   *
   * @param string $name
   * @return string
   */
  public function file($name) {
    return $this->kirby->roots()->templates() . DS . str_replace('/', DS, $name) . '.' . $this->extension;
  }
    /**
     * Returns all available template files
     *
     * @return array
     */
  public function files() {
    $files = dir::read($this->kirby->roots()->templates());
    $files = array_filter($files, function($file) {
      return f::extension($file) === $this->extension;
    });
    return array_map(function($file) {
      return f::name($file);
    }, $files);
  }
  /**
   * Renders the template by page with the additional data
   *
   * @param Page|string $template
   * @param array $data
   * @param boolean $return
   * @return string
   */
  public function render($template, $data = [], $return = true) {
    if($template instanceof Page) {
      $page = $template;
      $file = $page->templateFile();
      $data = $this->data($page, $data);
    } else {
      $file = $template;
      $data = $this->data(null, $data);
    }

    // check for an existing template
    if(!file_exists($file)) {
      var_dump($template);
      die();
      throw new Exception("The template $file could not be found");
    }
    // merge and register the template data globally
    $tplData = tpl::$data;
    tpl::$data = array_merge(\tpl::$data, $data);

    // load the template
    $pug = new Pug(array(
      'pretty' => true,
      'extension' => ".$this->extension",
      'cache' => __DIR__ . '/cache',
      'expressionLanguage' => 'php',
      'basedir' => site()->kirby->roots()->templates(),
      # This serves to not call kirby's `html` helper
      'pattern' => function ($pattern) {
          $args = func_get_args();
          $function = 'sprintf';
          if (is_callable($pattern) && $pattern!='html') {
              $function = $pattern;
              $args = array_slice($args, 1);
          }

          return call_user_func_array($function, $args);
      }
    ));
    $pug->filter('coffee-script', 'Pug\Filter\CoffeeScript');
    $pug->share('urlRoot', substr(\url("/"), strlen(url::base())));
    return $output = $pug->render($file, tpl::$data);
  }
}

$kirby->set('component', 'template', 'PugTemplate');
?>
