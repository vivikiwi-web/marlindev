<?php include ROOT . "app/views/parts/header.view.php" ?>

<div class="container">

    <div class="row">
        <div class="col-8 offset-2">
            
            <a href="user/add/" class="btn btn-success mt-4 mb-4">Add User</a>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $users as $user) : ?>
                        <tr>
                            <th scope="row"><?php echo $user->id; ?></th>
                            <td><a href=""><?php echo $user->name; ?></a></td>
                            <td><a href=""><?php echo $user->email; ?></a></td>
                            <td><a href=""><?php echo $user->password; ?></a></td>
                            <td>
                                <a href="user/edit/<?php echo $user->id; ?>" class="btn btn-warning me-2">Edit</a>
                                <a href="user/delete/<?php echo $user->id; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include ROOT . "app/views/parts/footer.view.php" ?>