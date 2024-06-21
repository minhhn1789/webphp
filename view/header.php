<?php
ini_set('display_errors', '1');
echo '
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">';
            if (isset($_SESSION['users']['searchable']) && $_SESSION['users']['searchable']) {
                $author_id = $_GET['author_id'] ?? '';
                $value = isset($_SESSION['users']['search']) ? ($_SESSION['users']['search']['value'] ?? '') : '';
                echo '<li >
                    <form class="search_form" action="/blog/controller/post/search.php" method="post">
                      <input value="'. $author_id .'" type="hidden" name="author_id">
                      <input value="'. $value .'" type="search" placeholder="Search title or content..." name="value">
                      <button type="submit" > Search</button >
                    </form >
                </li >';
            }
            echo '<li>
                    <a href="/blog/">Home</a>
                </li>';
                if (isset($_SESSION['users']['login'])) {
                    echo "                
                            <li class='dropdown'>
                                <a class='dropbtn'> Welcome ".$_SESSION['users']['name']. "</a>
                                <div class='dropdown-content'>
                                    <a class='dropdown_item-1' href='/blog/view/user/detail.php?id=".$_SESSION['users']['user_id']."'>Account</a>
                                    <a class='dropdown_item-2' href='/blog/view/posts/list.php'>My Posts</a>
                                    <a class='dropdown_item-2' href='/blog/view/posts/create.php'>Create Post</a>
                                    <a class='dropdown_item-3' href='/blog/controller/user/logout.php'>Logout</a>
                                </div>
                            </li>";
                }else{
                    echo "<li><a href='/blog/view/login.php'>Login</a></li>";
                }
                echo '
            </ul>
        </div>
    </div>
</nav>
';
