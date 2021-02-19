<?php include ROOT . "app/views/parts/header.view.php" ?>

<div class="container">

    <div class="row">
        <div class="col-8 offset-2 mt-5">

            <form action="user/create" method="post">
                <div class="form-group mt-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <label for="password_repeat">Repeat Password</label>
                    <input type="text" name="password_repeat" id="password_repeat" class="form-control">
                </div>
                <div class="form-group mt-3 mt-3">
                    <button class="btn btn-success">Add User</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include ROOT . "app/views/parts/footer.view.php" ?>