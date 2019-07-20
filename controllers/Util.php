<?php

class Util
{
    const page_404 = '404';
    const page_index = 'index.php';
    const page_header = 'header.php';
    const page_footer = 'footer.php';
    const page_sidebar = 'sidebar.php';

    const page_u = 'u'; // user

    const dir_user = 'user';

    const page_beranda = 'beranda';
    const page_aksi = 'aksi';

    const u_question = 'question';
    const u_answer = 'answer';

    const action = 'aksi';
    const action_add = 'tambah';
    const action_edit = 'perbaiki';
    const action_delete = 'hapus';

    const type_attribute_all = 'all';
    const type_attribute_primary = 'primary';
    const type_attribute_foreign = 'foreign';


    public static $_text_color_label_map = array(
        'green', 'aqua', 'red', 'light-blue', 'yellow'
    );

    public static $_text_color_hex_map = array(
        '#00a65a', '#00c0ef', '#dd4b39', '#3c8dbc', '#f39c12'
    );

    public static $_label_map = array(
        'info', 'warning', 'success', 'primary', 'danger'
    );

    public static $_tahun = array(
        2016,
        2017,
        2018,
        2019,
    );

    public static $_dir_map = array(
        self::page_u => self::dir_user,
    );

    static function _header()
    {
        require_once ABS_VIEW_PATH . DS . self::page_header;
    }

    static function _footer()
    {
        require_once ABS_VIEW_PATH . DS . self::page_footer;
    }

    static function _sidebar($sub = '')
    {
        require_once ABS_VIEW_PATH . DS . (empty($sub) ? '' : $sub . DS) . self::page_sidebar;
    }


    static function _a($page)
    {
        return URI_PATH . DS . self::page_index . DS . $page;
    }

    static function _a_u($sub_page, $action = false)
    {
        return self::_a(($action ? self::page_aksi . DS : '') . self::page_u . DS . $sub_page);
    }


    public static function _a_beranda()
    {
        return self::_a(self::page_beranda);
    }


    public static function _breadcrumb($page = '')
    {
        $_tmp = '<ol class="breadcrumb">';
        $_tmp .= '<li><a href="' . self::_a_beranda() . '">Beranda</a></li>';
        if (strtolower($page) != self::page_beranda) {
            if ($page == self::page_404)
                $_tmp .= '<li>404</li>';
            else {
                foreach (Routes::_gi()->_depths() as $_i => $_depth) {
                    if ($_i == 0) continue;
                    $_tmp .= '<li ' . (strtolower($page) == $_depth ? 'class="active"' : '') . '>' . self::_camel_case($_depth) . '</li>';
                    if ($_depth == self::nav_search)
                        break;
                }
            }
        }
        $_tmp .= '</ol>';
        return $_tmp;
    }

    static function _camel_case($string, $delimiter = '-', $separator = ' ')
    {
        return implode(array_map(function ($x) use ($separator) {
            return ucfirst($x) . $separator;
        }, explode($delimiter, $string)));
    }

    static function _filter_class_attr($attributes, $type = self::type_attribute_primary, $additional_exclude = array())
    {
        return array_filter($attributes, function ($v) use ($type, $additional_exclude) {
            switch ($type) {
                case self::type_attribute_primary :
                    return substr($v, 0, 1) != '_' && !in_array($v, $additional_exclude);
                    break;
                case self::type_attribute_foreign :
                    return substr($v, 0, 1) == '_' && !in_array($v, $additional_exclude);
                    break;
                case self::type_attribute_all :
                default:
                    return !in_array($v, $additional_exclude);
            }
        });
    }

    static function _class_name($class_path)
    {
        return $class_path;
    }

    static function _model_path($class_path)
    {
        return __NAMESPACE__ . '\\M' .
            self::_trim_first_char(
                self::_class_name($class_path), 'C'
            );
    }

    static function _model_name($class_path)
    {
        return 'M' . self::_trim_first_char(
                self::_class_name($class_path), 'C'
            );
    }

    static function _table_name($class_path, $type = 'C')
    {
        return strtolower(
            self::_trim_first_char(
                self::_class_name($class_path)
                , $type)
        );
    }

    static function _trim_first_char($str, $char)
    {
        return substr($str, 0, 1) == $char ?
            substr($str, 1) : $str;
    }

    static function _to_array($vars, $type = self::type_attribute_all, $exclude = array())
    {
        $_out = array();
        $_keys = self::_filter_class_attr(array_keys($vars), $type, $exclude);
        foreach ($_keys as $_key)
            $_out[$_key] = is_null($vars[$_key]) ? '' : $vars[$_key];
        return $_out;
    }

    /**
     * Sync default args dengan array yg diberikan
     *
     * @param $default
     * @param $destination
     * @return array
     */
    static function _params($default, $destination)
    {
        $return = array();
        foreach ($default as $k => $d) {
            if (isset($destination[$k])) {
                $_tmp = $destination[$k];
                if (isset($_GET[$k]))
                    $_tmp = self::_sanitize($_tmp);
                $return[$k] = $_tmp;
            } else $return[$k] = $d;
        }
        return $return;
    }

    static function _sanitize($str)
    {
        return str_replace(array('&', '<', '>', '/', '\\', '"', "'", '?', '+', '`'), '', $str);
    }

    /**
     * @param $field
     * @return bool
     */
    static function _empty($field)
    {
        return is_null($field) || empty($field);
    }

    /**
     * @param $array
     * @param $key
     * @param string $default
     * @return string|array
     */
    static function _arr($array, $key, $default = '')
    {
        return self::_empty($array[$key]) ? $default : $array[$key];
    }

    static function _notif_crud($action, $status, $message = '')
    {
        $message = str_replace('{{action}}', $action, $message);
        $message = str_replace('{{status}}', $status, $message);
        return in_array($status, self::$_status_map) ? '<div class="alert alert-' . self::$_status_class_map[$status] . ' alert-dismissible">' .
            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' .
            '<i class="icon ' . self::$_status_icon_map[$status] . '"></i>&nbsp;&nbsp;' . $message . '</div>' : '';
    }

    /**
     * @param $base_url
     * @param $total_data
     * @param $current_page
     * @param int $data_per_page
     * @param int $range_data
     * @return string
     */
    static function _paging($base_url, $total_data, $current_page, $data_per_page = 10, $range_data = 3)
    {

        $out = '<span class="text-muted">' . $total_data . ' Item' . ($total_data > 1 ? 's' : '') . '</span>';

        /** cek apakah memungkinkan untuk paging */
        if ($total_data > $data_per_page && $data_per_page > 0) {
            $total_page = ceil($total_data / $data_per_page);

            /** batas minimum */
            $ii = ($ii = $current_page - $range_data) < 1 ? 1 : $ii;

            /** batas maksimum */
            $iii = ($iii = $current_page + $range_data) > $total_page ? $total_page : $iii;

            $out .= '<ul class="pagination pagination-sm no-margin pull-right">';

            /** tampilkan left arrow */
            if ($current_page == 1)
                $out .= '<li><span>&laquo;</span></li>';
            else
                $out .= '<li><a href="' . $base_url . '&page=1">&laquo;</a></li>';

            /** jika tidak mepet dengan nilai minimum, tampilkan titik-titik */
            if ($ii != 1)
                $out .= '<li><span>...</span></li>';

            /** mulai iterasi sesuai range yang telah ditentukan */
            for ($i = $ii; $i <= $iii; $i++)
                $out .= '<li class="' . ($current_page == $i ? 'active' : '') . '">' .
                    '<a href="' . $base_url . '&page=' . $i . '">' . $i . '</a></li>';

            /** jika tidak mepet dengan nilai maksimum, tampilkan titik-titik */
            if ($iii != $total_page)
                $out .= '<li><span>...</span></li>';

            /** tampilkan right arrow */
            if ($current_page == $total_page)
                $out .= '<li><span>&raquo;</span></li>';
            else
                $out .= '<li><a href="' . $base_url . '&page=' . $total_page . '">&raquo;</a></li>';

            $out .= '</ul>';

        }

        return $out;
    }

    static function _minify_HTML_output($buffer)
    {

        /** hanya berlaku pada tag HTML */
        if (preg_match('/\<html/i', $buffer) == 1
            && preg_match('/\<\/html\>/i', $buffer) == 1)
            $buffer = preg_replace(array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'), array('>', '<', '\\1'), $buffer);

        return $buffer;
    }

    static function _notify() {
        $output = "";
        if (Routes::_gi()->_depth(2) == Util::status_success):
            switch (Routes::_gi()->_depth(3)) {
                case Util::action_add:
                    $output = "<script>toastr.success('Sukses Menambah Data','')</script>";
                    break;
                case Util::action_edit:
                    $output = "<script>toastr.success('Sukses Edit Data','')</script>";
                    break;
                default:
                    $output = "<script>toastr.success('Sukses Hapus Data','')</script>";
                    break;
            }
        endif;
        return $output;
    }

    static function _to_camel_case($string, $delimiter = ' ') {
        return str_replace($delimiter, '_', strtolower($string));
    }

    static function _remove_char($string, $char = ' ') {
        return str_replace($char, '', $string);
    }

    static function _redirect($target = URI_PATH)
    {
        header('Location: ' . $target);
        die();
    }

    static function _is_SSL_URI()
    {
        return strpos(strtolower(URI_PATH), 'https://') !== false;
    }

    static function _is_SSL_request()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
    }

    static function _validate_URI($server)
    {
        if (self::_is_SSL_URI() && !self::_is_SSL_request())
            self::_redirect('https://' . $server['SERVER_NAME'] . $server['REQUEST_URI']);
    }
}