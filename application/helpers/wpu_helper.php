<?php 

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    }
    else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        $queryMenu = $ci->db->get_where('user_Menu', ['menu'=>$menu])->row_array();
        $menu_id = $queryMenu['id'];
        $userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id,
        'menu_id' => $menu_id]); 
        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();
    $query = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);
    if ($query->num_rows() > 0) {
        echo 'checked';
    }
}

function check_(Type $var = null)
{
    # code...
}

function secondsToTime($seconds)
{
    // var_dump($seconds);
    // die;
    if ($seconds > 0) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        // var_dump($dtF->diff($dtT)->format('%a'));
        // die;
        return $dtF->diff($dtT)->format('%a hari, %h jam , %i menit dan %s detik');
    }
    else {
        $seconds = $seconds * -1;
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");

        
        if ($dtF->diff($dtT)->format('%a') == '0') {
            if ($dtF->diff($dtT)->format('%h') == '0') {
                if ($dtF->diff($dtT)->format('%i') == '0') {
                    return $dtF->diff($dtT)->format('lewat %s detik');
                }
                return $dtF->diff($dtT)->format('lewat %i menit dan %s detik');
            }
            return $dtF->diff($dtT)->format('lewat %h jam , %i menit dan %s detik');
        }

        return $dtF->diff($dtT)->format('lewat %a hari, %h jam , %i menit dan %s detik');
    }
}