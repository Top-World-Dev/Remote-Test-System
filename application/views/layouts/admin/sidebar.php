    <div class="mdk-drawer js-mdk-drawer" id="default-drawer">
        <div class="mdk-drawer__content">
            <div class="sidebar sidebar-dark-dodger-blue sidebar-left" data-perfect-scrollbar>
                <a href="<?=site_url('admin/problem')?>" class="sidebar-brand ">
                    <span class="avatar avatar-xl sidebar-brand-icon h-auto">
                        <span class="avatar-title rounded bg-primary"><img style="background-color: #303956; width: 200%;" src="<?=base_url("assets/img/logo.png")?>" class="img-fluid" alt="logo" /></span>
                    </span>
                </a>

        <?php
            foreach($list as $key=>$items) 
            {
                if($items['link'] == 'dropdown')
                {
        ?>
                    <div class="sidebar-heading"><?=$key?></div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item <?=($items['grouptext'] == $menu?'active open':'')?>">
                            <a class="sidebar-menu-button" data-toggle="collapse" href="#<?=$items['id']?>">
                                <span class="material-icons sidebar-menu-icon--left"><?=$items['icon']?></span>
                                <?=$items['grouptext']?>
                                <span class="ml-auto sidebar-menu-toggle-icon"></span>
                            </a>
                            <ul class="sidebar-submenu collapse show sm-indent" id="<?=$items['id']?>">
        <?php
                            foreach($items as $ikey=>$item) 
                            {
                                if($ikey == 'icon' || $ikey == 'link' || $ikey == 'id' || $ikey == 'grouptext') continue;
        ?>
                                <li class="sidebar-menu-item <?=($item['title'] == $page?'active':'')?>">
                                    <a class="sidebar-menu-button" href="<?=site_url($item['link'])?>">
                                        <span class="sidebar-menu-text"><?=$item['title']?></span>
                                    </a>
                                </li>
        <?php
                            }
        ?>
                            </ul>
                        </li>
                    </ul>
        <?php
                }

                else 
                {
        ?>
                    <div class="sidebar-heading"><?=$key?></div>
                    <ul class="sidebar-menu">
                        <li class="sidebar-menu-item <?=($items['grouptext'] == $menu?'active open':'')?>">
                            <a class="sidebar-menu-button" href="<?=site_url($items['link'])?>">
                                <span class="material-icons sidebar-menu-icon--left"><?=$items['icon']?></span>
                                <?=$items['grouptext']?>
                            </a>
                        </li>
                    </ul>
        <?php
                }
        ?>

        <?php
            }
        ?>

                <!-- <div class="sidebar-heading">Applications</div> 
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a class="sidebar-menu-button " href="11.html">
                            <span class="material-icons sidebar-menu-icon--left">school</span>
                            Student
                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                        </a>
                        <ul class="sidebar-submenu collapse sm-indent" id="student_menu">
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-index.html">
                                    <span class="sidebar-menu-text">Home</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-courses.html">
                                    <span class="sidebar-menu-text">Browse Courses</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-paths.html">
                                    <span class="sidebar-menu-text">Browse Paths</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-dashboard.html">
                                    <span class="sidebar-menu-text">Student Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-my-courses.html">
                                    <span class="sidebar-menu-text">My Courses</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-paths.html">
                                    <span class="sidebar-menu-text">My Paths</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-path.html">
                                    <span class="sidebar-menu-text">Path Details</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-course.html">
                                    <span class="sidebar-menu-text">Course Preview</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-lesson.html">
                                    <span class="sidebar-menu-text">Lesson Preview</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-take-course.html">
                                    <span class="sidebar-menu-text">Take Course</span>
                                    <span class="sidebar-menu-badge badge badge-accent badge-notifications ml-auto">PRO</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-take-lesson.html">
                                    <span class="sidebar-menu-text">Take Lesson</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-take-quiz.html">
                                    <span class="sidebar-menu-text">Take Quiz</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-quiz-results.html">
                                    <span class="sidebar-menu-text">My Quizzes</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-quiz-result-details.html">
                                    <span class="sidebar-menu-text">Quiz Result</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-path-assessment.html">
                                    <span class="sidebar-menu-text">Skill Assessment</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-student-path-assessment-result.html">
                                    <span class="sidebar-menu-text">Skill Result</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="sidebar-heading">UI</div>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item active open">
                        <a class="sidebar-menu-button" data-toggle="collapse" href="#components_menu">
                            <span class="material-icons sidebar-menu-icon--left">tune</span>
                            Components
                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                        </a>
                        <ul class="sidebar-submenu collapse show sm-indent" id="components_menu">
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-buttons.html">
                                    <span class="sidebar-menu-text">Buttons</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-avatars.html">
                                    <span class="sidebar-menu-text">Avatars</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item active">
                                <a class="sidebar-menu-button" href="fixed-ui-forms.html">
                                    <span class="sidebar-menu-text">Forms</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-loaders.html">
                                    <span class="sidebar-menu-text">Loaders</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-tables.html">
                                    <span class="sidebar-menu-text">Tables</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-cards.html">
                                    <span class="sidebar-menu-text">Cards</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-icons.html">
                                    <span class="sidebar-menu-text">Icons</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-tabs.html">
                                    <span class="sidebar-menu-text">Tabs</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-alerts.html">
                                    <span class="sidebar-menu-text">Alerts</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-badges.html">
                                    <span class="sidebar-menu-text">Badges</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-progress.html">
                                    <span class="sidebar-menu-text">Progress</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button" href="fixed-ui-pagination.html">
                                    <span class="sidebar-menu-text">Pagination</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item">
                                <a class="sidebar-menu-button disabled" href="">
                                    <span class="sidebar-menu-text">Disabled</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul> -->
            </div>
        </div>
    </div>