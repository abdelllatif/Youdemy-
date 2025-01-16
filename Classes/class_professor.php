<?php


class Teacher extends User {
    public $expertise;
    public $followers_count;
    public $is_verified;

    public function __construct($id, $name, $email, $password, $expertise, $followers_count = 0, $is_verified = false, $avatar_path = 'default_avatar.jpg', $bio = '', $status = 'active', $created_at = null) {
        parent::__construct($id, $name, $email, $password, 'teacher', $avatar_path, $bio, $status, $created_at);
        $this->expertise = $expertise;
        $this->followers_count = $followers_count;
        $this->is_verified = $is_verified;
    }
}



class Video {
    public $id;
    public $playlist_id;
    public $title;
    public $description;
    public $video_path;
    public $duration;
    public $order_number;
    public $created_at;
    public $updated_at;

    public function __construct($id, $playlist_id, $title, $description, $video_path, $duration, $order_number, $created_at = null, $updated_at = null) {
        $this->id = $id;
        $this->playlist_id = $playlist_id;
        $this->title = $title;
        $this->description = $description;
        $this->video_path = $video_path;
        $this->duration = $duration;
        $this->order_number = $order_number;
        $this->created_at = $created_at ?? date('Y-m-d H:i:s');
        $this->updated_at = $updated_at ?? date('Y-m-d H:i:s');
    }
}

class Enrollment {
    public $id;
    public $playlist_id;
    public $student_id;
    public $status;
    public $access_enabled;

    public function __construct($id, $playlist_id, $student_id, $status = 'active', $access_enabled = true) {
        $this->id = $id;
        $this->playlist_id = $playlist_id;
        $this->student_id = $student_id;
        $this->status = $status;
        $this->access_enabled = $access_enabled;
    }
}

class PlaylistLike {
    public $id;
    public $playlist_id;
    public $user_id;
    public $created_at;

    public function __construct($id, $playlist_id, $user_id, $created_at = null) {
        $this->id = $id;
        $this->playlist_id = $playlist_id;
        $this->user_id = $user_id;
        $this->created_at = $created_at ?? date('Y-m-d H:i:s');
    }
}

class PlaylistReview {
    public $id;
    public $playlist_id;
    public $student_id;
    public $rating;
    public $comment;
    public $created_at;
    public $updated_at;

    public function __construct($id, $playlist_id, $student_id, $rating, $comment = '', $created_at = null, $updated_at = null) {
        $this->id = $id;
        $this->playlist_id = $playlist_id;
        $this->student_id = $student_id;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->created_at = $created_at ?? date('Y-m-d H:i:s');
        $this->updated_at = $updated_at ?? date('Y-m-d H:i:s');
    }
}
?>