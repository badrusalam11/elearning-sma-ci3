<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Model extends CI_Model
{
    public function getUser()
    {

        $query = "SELECT  `user`.`id`, `user`.`name`, `user`.`email`, `user`.`is_active`, `user`.`date_created`,
        `student`.`id` as student_id, `student`.`NISN`, `student`.`class`, 
        `teacher`.`id` as teacher_id, `teacher`.`NIP`, 
        `user_role`.`id` as role_id, `user_role`.`name` as role_name
            FROM `user` 
            LEFT JOIN `student`
                ON `user`.`id` = `student`.`user_id`
            LEFT JOIN `teacher`
                ON `user`.`id` = `teacher`.`user_id`
            LEFT JOIN `user_role`
                ON `user`.`role_id` = `user_role`.`id`    
            ";

        $result = $this->db->query($query)->result_array();
        $i = 0;
        foreach ($result as $r) {
            $teacher_id = intval($r['teacher_id']);
            $query2 = "SELECT `teacher_subject`.`teacher_id` as teacher_id, 
            `teacher_subject`.`subject_id` as subject,
            `subject`.`name` as subject_name
                FROM `teacher_subject`
                LEFT JOIN  `subject`
                    ON `teacher_subject`.`subject_id` = `subject`.`id`
                WHERE `teacher_subject`.`teacher_id` = '$teacher_id'
            ";
        $result2= $this->db->query($query2)->result_array();
        $result[$i]['teacher'] = $result2; 
        $i++;
    }
    // echo"<pre>";
    // var_dump($result);
    // echo"</pre>";
    //     die;
        return $result;

        // $query = "SELECT  `user`.`id`, `user`.`name`, `user`.`email`, `user`.`is_active`, `user`.`date_created`,
        // `student`.`id` as student_id, `student`.`NISN`, `student`.`class`, 
        // `teacher`.`id` as teacher_id, `teacher`.`NIP`, 
        // `user_role`.`id` as role_id, `user_role`.`name` as role_name,
        // `subject`.`id` as subject_id, `subject`.`name` as subject_name
        //     FROM `user` 
        //     LEFT JOIN `student`
        //         ON `user`.`id` = `student`.`user_id`
        //     LEFT JOIN `teacher`
        //         ON `user`.`id` = `teacher`.`user_id`
        //     LEFT JOIN `user_role`
        //         ON `user`.`role_id` = `user_role`.`id`    
        //     LEFT JOIN  `teacher_subject`
        //         ON `teacher`.`id` = `teacher_subject`.`teacher_id`
        //     LEFT JOIN `subject`
        //         ON `teacher_subject`.`subject_id` = `subject`.`id`
        //     ";
        // $result =  $this->db->query($query)->result_array();
        // $role_id = [];
        // $role_name = [];
        // $new_result = [];
        // $i = 0;
        // foreach ($result as $r) {
        //     $new_result['name'][$i] = $r['name'];
        //     $new_result['subject_id'][$i] = $r['subject_id'];
        //     $i++;
        // }
        // echo"<pre>";
        // var_dump($new_result);
        // echo"</pre>";
        
        // die;
        
    }   

    public function insertUser($post)
    {
        $date_created = time();
        $hash = password_hash($post['password'],PASSWORD_DEFAULT);
        // $query = "BEGIN;
        // INSERT INTO user (name, email, image, password, role_id, is_active, date_created)
        // VALUES (
        //     '$post[name]',
        //     '$post[email]',
        //     'default.jpg',
        //     '$hash',
        //     '$post[role_id]', 
        //     '$post[is_active]', 
        //     '$date_created'
        //     );
        // INSERT INTO student (NISN, class, user_id) VALUES('$post[NISN]', '$post[class]', LAST_INSERT_ID());
        // COMMIT
        // ";
        //insert user
        $query1 = $this->db->insert('user', [
            'name' =>  $post['name'],
            'email' =>  $post['email'],
            'image' =>  'default.jpg',
            'password' =>  $hash,
            'role_id' =>  $post['role_id'],
            'is_active' =>  $post['is_active'],
            'date_created' =>  $date_created
        ]);
        $user_id = $this->db->insert_id();


        if ($post['role_id']==2) {
            $query2 = $this->db->insert('student',[
                'NISN'=> $post['NISN'],
                'class'=> $post['class'],
                'user_id'=> $user_id
            ]);
        }
        elseif ($post['role_id']==3) {
            $query2 = $this->db->insert('teacher', [
                'NIP' => $post['NIP'],
                'user_id' => $user_id
            ]);
            $teacher_id = $this->db->insert_id();
            foreach ($post['subject_id'] as $s) {
                $this->db->insert('teacher_subject', [
                    'teacher_id' => $teacher_id,
                    'subject_id' => $s
                ]);
            }
        }

        if (isset($query2)) {
            if ($query1 == true && $query2 == true) {
                return true;
            }
            return false;
        }
        else{
            if ($query1) {
                return true;
            }
            return false;
        }
        
    }

    public function updateUser($post)
    {
        
        //update user
        $this->db->where('id', $post['id']);
        $query1 = $this->db->update('user', [
            'name' =>  $post['name'],
            'email' =>  $post['email'],
            'is_active' =>  $post['is_active']
        ]);
        // $user_id = $this->db->insert_id();


        if ($post['role_id'] == 2) {
            $this->db->where('user_id',$post['id']);
            $query2 = $this->db->update('student', [
                'NISN' => $post['NISN'],
                'class' => $post['class']
            ]);
        } elseif ($post['role_id'] == 3) {
            $this->db->where('user_id',$post['id']);
            $query2 = $this->db->update('teacher', [
                'NIP' => $post['NIP']
            ]);
        }

        if (isset($query2)) {
            if ($query1 == true && $query2 == true) {
                return true;
            }
            return false;
        } else {
            if ($query1) {
                return true;
            }
            return false;
        }
    }

    public function check_unique_user_email($id = '', $email)
    {
        $this->db->where('email', $email);
        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        return $this->db->get('user')->num_rows();
    }



}
