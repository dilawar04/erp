<?php

namespace App;

//Todo::Dev
use function Composer\Autoload\includeFile;
if(\File::exists(theme_dir('includes/shortcodes.php', true))) {
    includeFile(theme_dir('includes/shortcodes.php', true));
}

class Theme extends Page
{
    /**
     * @var array
     */
    private static $meta_tags;
    private static $title;

    private static $template = 'default';

    /**
     * @param null $view
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function view($view = null, $data = [], $mergeData = [])
    {
        return view_theme($view, $data, $mergeData);
    }

    /**
     * @param $key
     * @param null $value
     * @return bool|mixed
     */
    public static function meta($key, $value = null){
        if($value === null){
            if(in_array($key, ['keywords', 'description']) && empty(self::$meta_tags[$key])){
                return opt('meta_' . $key);
            }
            return self::$meta_tags[$key];
        } else {
            self::$meta_tags[$key] = $value;
            return true;
        }
    }

    /**
     * @param null|string $title
     * @param string $separator
     * @return string
     */
    public static function title($title = null, $separator = ' | '){
        if($title == null){
            return self::$title;
        }
        $title_prefix = opt('title_prefix');
        $title_prefix = (!empty($title_prefix) ? $title_prefix . $separator : '');

        $title_suffix = opt('title_suffix');
        $title_suffix = (!empty($title_suffix) ? $separator . $title_suffix : '');

        self::$title = $title_prefix . $title . $title_suffix;
        return self::$title;
    }

    /**
     * @return mixed
     */
    public static function get_title(){
        return self::$title;
    }

    /**
     * @param null $name
     * @return mixed
     */
    public static function template($name = null){
        if($name == null){
            return theme_dir('templates/' . self::$template);
        }
        return self::$template = $name;
    }


    /**
     * @return string
     */
    public static function getMetaTags(){
        $meta_html = '';
        foreach (self::$meta_tags as $key => $value) {
            if(!empty($value)){
                $meta_html .= '<meta name="' . $key . '" content="' . $value . '" />' . "\n";
            }
        }
        return $meta_html;
    }
    /**
     * @param $title
     * @param $keywords
     * @param $description
     * @param string $image
     */
    public static function setMetaTags($title, $keywords, $description, $image = '')
    {
        # Meta
        self::title($title);
        self::meta('keywords', $keywords);
        self::meta('description', $description);

        list($img_width, $img_height, $img_type, $img_attr) = getimagesize($image);
        # FB Meta
        self::meta('og:title', $title);
        self::meta('og:description', $description);
        self::meta('og:type', 'article');
        self::meta('og:url', url()->current());
        self::meta('og:image', $image);
        self::meta('og:image:type', image_type_to_mime_type($img_type));
        self::meta('og:image:width', $img_width);
        self::meta('og:image:height', $img_height);

        # Twitter Meta
        self::meta('twitter:card', 'photo');
        self::meta('twitter:title', $title);
        self::meta('twitter:description', $description);
        self::meta('twitter:site', '@');
        self::meta('twitter:creator', '@');
        self::meta('twitter:image:src', $image);
        self::meta('twitter:image:width', $img_width);
        self::meta('twitter:image:height', $img_height);
    }

    /**
     * @param $identifier
     * @param bool $obj
     * @return string
     */
    public static function block($identifier, $obj = false)
    {
        $block = \App\StaticBlock::where(['identifier' => $identifier, 'status' => 'Active'])->first();
        if(!$obj){
            return do_shortcode($block->content);
        }
        return $block;
    }

    /**
     * @param null $id
     * @param string $where
     * @param bool $child_page
     * @return array|mixed
     */
    public static function page($id = null, $where = "", $child_page = false)
    {
        if($id > 0){
            $where .= ' AND pages.id=' . intval($id);
        }

        $sql_pages = "SELECT pages.*,
              pages.content,
              pages.parent_id AS page_parent_id,
              menus.id AS menu_id,
              menus.parent_id,
              menus.menu_title,
              menus.menu_link,
              IF(menus.menu_type = '', 'custom', menus.menu_type) AS menu_type,
              menus.menu_type_id,
              menus.ordering
            FROM pages
              LEFT JOIN menus ON (pages.id = menus.menu_link)
            WHERE 1 " . $where . " ORDER BY pages.ordering ASC, pages.id DESC";
        if($child_page){
            $page_rows = \DB::select($sql_pages);
            foreach ($page_rows as $k => $page_row) {
                $page_rows[$k]->content = replace_urls($page_rows[$k]->content);
            }
            return $page_rows;
        }
        $page_row = \DB::selectOne($sql_pages);
        $page_row->content = replace_urls($page_row->content);
        return $page_row;
    }
}
