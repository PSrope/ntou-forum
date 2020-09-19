<?php

require_once(__DIR__ . '/../includes/configs.php');

Session::REQUIRE_LOGIN();

if (!(isset($post) && $post) ||
    !(isset($author) && $author)) {
    die('Something went wrong.');
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $FORUM->edit_post($post, ['title' => $title, 'content' => $content]);
    Utility::redirect_to('post.php?id=' . $post->id);
}

?>

<form action="" method="POST">
    <h1>&nbsp;編輯文章</h1>
    <div class="hr_line"></div>
    <br>
    <div class="post_theme" value="文章">
        <span class="post_title">標題名稱：</span>
        <input id="p_title" name="title" type="text" value="<?php echo $post->title; ?>" required>
        <br>
    </div>

    <div class="post_theme con" value="文章">
        <span class="post_context">文章內容：</span>
        <br>
        <center>
            <textarea id="p_context" name="content">
<?php echo $post->content; ?></textarea>
            <input name="submit" id="postButton" class="log_button button_mes" type="submit" value="編輯完成">
            <input id="cancelButton" class="log_button button_mes" type="button" value="取消編輯" onclick="location.href='post.php?id=<?php echo $post_id; ?>'">
        </center>
    </div>

</form>
