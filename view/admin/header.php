<?php
ini_set('display_errors', '1');
echo '	
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">';
            if (isset($_SESSION['admin']['searchable']) && $_SESSION['admin']['searchable']) {
                $author_id = $_GET['author_id'] ?? '';
                $value = isset($_SESSION['admin']['search']) ? ($_SESSION['admin']['search']['value'] ?? '') : '';
                echo '<li >
                    <form class="search_form" action="/blog/controller/admin/post/search.php" method="post">
                      <input value="'. $author_id .'" type="hidden" name="author_id">
                      <input value="'. $value .'" type="search" placeholder="Search title or content..." name="value">
                      <button type="submit" > Search</button >
                    </form >
                </li >';
            }
            echo '<li>
                    <a href="/blog/view/admin">Home</a>
                </li>';
                if (isset($_SESSION['admin']['login_admin'])) {
                    echo "                
                            <li class='dropdown'>
                                <a class='dropbtn'> Welcome ".$_SESSION['admin']['name_admin']. "</a>
                                <div class='dropdown-content'>
                                    <a class='dropdown_item-1' href='/blog/view/admin/detail.php?id=".$_SESSION['admin']['admin_id']."'>Account</a>
                                    <a class='dropdown_item-2' href='/blog/view/admin/list_users.php'>List Users</a>
                                    <a class='dropdown_item-2' href='/blog/view/admin/list_admin.php'>List Admin</a>
                                    <a class='dropdown_item-2' href='/blog/view/admin/posts/create.php'>Create Posts</a>
                                    <a class='dropdown_item-2' href='/blog/view/admin/posts/list_by_author.php?author_id=".$_SESSION['admin']['admin_id']."'>My Posts</a>
                                    <a class='dropdown_item-3' href='/blog/controller/admin/logout.php'>Logout</a>
                                </div>
                            </li>";
                }else{
                    header('Location: index.php');
                    exit;
                }
                echo '
            </ul>
        </div>
    </div>
</nav>
';
