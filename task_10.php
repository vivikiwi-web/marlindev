<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>
            Подготовительные задания к курсу
        </title>
        <meta name="description" content="Chartist.html">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
        <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
        <link rel="stylesheet" media="screen, print" href="css/statistics/chartist/chartist.css">
        <link rel="stylesheet" media="screen, print" href="css/miscellaneous/lightgallery/lightgallery.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
    </head>
    <body class="mod-bg-1 mod-nav-link ">

        <?php

            $textInserted = '';
            $text = '';
            /**
             * Connect to Database via PDO
             *
             * @param string $user
             * @param string $pass
             * @return object
             */
            function dbConnect() {

                $user = 'root';
                $pass = 'root';

                try {
                    return new PDO( 'mysql:host=localhost;dbname=marlindev_1level_9task', $user, $pass );
                } catch (PDOException $e) {
                    echo 'Error: ' . $e->getMessage() . '<br/>';
                    die;
                }
            }

            /**
             * Insert in database table 'content'
             *
             * @param [type] $value
             * @return object
             */
            function dbInsert ( $value ) {

                $pdo = dbConnect(); // Connect to Database

                $sql = "INSERT INTO content (text) VALUES (?)";
                $stmt = $pdo->prepare( $sql );
                $stmt->execute( [ htmlspecialchars( $value ) ] );

                return $stmt;
            }

            function dbFind ( $value ) {

                $pdo = dbConnect(); // Connect to Database

                $sql = "SELECT id FROM content WHERE text=?";
                $stmt = $pdo->prepare( $sql );
                $stmt->execute( [$value] );
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result;
            }
        
            // Check if FROM was Submited, if yes then insert value in databse
            if ( isset($_POST['text']) ) {

                $text = $_POST['text'];

                $textExists = dbFind( $text );

                $textInserted = 'exist';
                if ( ! $textExists  ) {
                    $textInsert = dbInsert ( $text );
                    if ( $textInsert->rowCount() > 0 ) {
                        $textInserted = 'inserted';
                        $text = '';
                    }
                }

                $stmt = NULL;

            }

        ?>
        <main id="js-page-content" role="main" class="page-content">

            <div class="col-md-6">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Задание
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <div class="panel-content">
                                <div class="form-group">
                                    <?php if ( $textInserted == 'inserted' ) : ?>
                                        <div class="alert alert-success fade show" role="alert">
                                            Text has been inserted in database.
                                        </div>
                                    <?php elseif ( $textInserted == 'exist' ) : ?>
                                        <div class="alert alert-danger fade show" role="alert">
                                            You should check in on some those fields below.
                                        </div>
                                    <?php endif; ?>
                                    <form action="task_10.php" method="POST">
                                        <label class="form-label" for="simpleinput">Text</label>
                                        <input type="text" id="simpleinput" name="text" class="form-control" value="<?php echo $text; ?>">
                                        <button class="btn btn-success mt-3">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        

        <script src="js/vendors.bundle.js"></script>
        <script src="js/app.bundle.js"></script>
        <script>
            // default list filter
            initApp.listFilter($('#js_default_list'), $('#js_default_list_filter'));
            // custom response message
            initApp.listFilter($('#js-list-msg'), $('#js-list-msg-filter'));
        </script>
    </body>
</html>
