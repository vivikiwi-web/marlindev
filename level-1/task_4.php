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
                    <?php 

                        $progressBarItems = [
                            [
                                'title' => 'My Tasks',
                                'title-class' => 'd-flex mt-2',
                                'value' => '130 / 500',
                                'bar-wrapper-class' => 'progress progress-sm mb-3',
                                'bar-class' => 'progress-bar bg-fusion-400',
                                'bar-role' => 'progressbar',
                                'bar-valuenow' => '65',
                                'bar-valuemin' => '0',
                                'bar-valuemax' => '100',
                            ],
                            [
                                'title' => 'My Tasks',
                                'title-class' => 'd-flex',
                                'value' => '440 TB',
                                'bar-wrapper-class' => 'progress progress-sm mb-3',
                                'bar-class' => 'progress-bar bg-success-500',
                                'bar-role' => 'progressbar',
                                'bar-valuenow' => '34',
                                'bar-valuemin' => '0',
                                'bar-valuemax' => '100',
                            ],
                            [
                                'title' => 'Bugs Squashed',
                                'title-class' => 'd-flex',
                                'value' => '77%',
                                'bar-wrapper-class' => 'progress progress-sm mb-3',
                                'bar-class' => 'progress-bar bg-info-400',
                                'bar-role' => 'progressbar',
                                'bar-valuenow' => '77',
                                'bar-valuemin' => '0',
                                'bar-valuemax' => '100',
                            ],
                            [
                                'title' => 'User Testing',
                                'title-class' => 'd-flex',
                                'value' => '7 days',
                                'bar-wrapper-class' => 'progress progress-sm mb-g',
                                'bar-class' => 'progress-bar bg-primary-300',
                                'bar-role' => 'progressbar',
                                'bar-valuenow' => '84',
                                'bar-valuemin' => '0',
                                'bar-valuemax' => '100',
                            ],
                        ];
                    ?>
                    <div class="panel-container show">
                        <div class="panel-content">

                            <?php foreach ( $progressBarItems as $item) : ?>

                                <div class="<?php echo $item['title-class']; ?>">
                                    <?php echo $item['title']; ?>
                                    <span class="d-inline-block ml-auto"><?php echo $item['value']; ?></span>
                                </div>
                                <div class="<?php echo $item['bar-wrapper-class']; ?>">
                                    <div class="<?php echo $item['bar-class']; ?>" role="<?php echo $item['bar-role']; ?>" style="width: <?php echo $item['bar-valuenow']; ?>%;" aria-valuenow="<?php echo $item['bar-valuenow']; ?>" aria-valuemin="<?php echo $item['bar-valuemin']; ?>" aria-valuemax="<?php echo $item['bar-valuemax']; ?>"></div>
                                </div>

                            <?php endforeach; ?>

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
