 			<div class="status-panel text-center">
	                    <div>
	                        <!-- <div class="space-block"></div> -->
	                        <div class="thumb1-first">
	                            <div class="A">
	                                <div style="margin: 3px;">
	                                    <div class="progress-bar-linkedin progress-bar-animated" role="progressbar">Answered Correctly 85%</div>
	                                </div>
	                                <div class="B">THE THEORY OF DEMAND & SUPPLY QUESTION NO: 03
	                                </div>
	                            </div>
	                        </div>
	                        <div class="thumb1-second">
	                            <div class="A">
	                                <div class="B">SQ</div>
	                                <div class="C">Y</div>
	                            </div>
	                        </div>
	                        <div class="thumb1-third">
	                            <div class="A">
	                                <div class="B">TQ</div>
	                                <div class="C" style="color: #353232;">1500</div>
	                            </div>
	                        </div>
                    
	                        <div class="thumb2-first">
	                            <div class="A">
	                                <div class="B">Time Elapsed</div>
	                                <div class="C">
	                                    <div id="clockdiv">
	                                        <div>
	                                            <span class="hours" id="hours"></span>
	                                            <div class="smalltext">HR</div>
	                                        </div>
	                                        <div>
	                                            <span class="minutes" id="minutes"></span>
	                                            <div class="smalltext">MIN</div>
	                                        </div>
	                                        <div>
	                                            <span class="seconds" id="seconds"></span>
	                                            <div class="smalltext">SEC</div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>

	                        <div class="thumb2-second" >
	                            <div class="A">
	                                <div class="B">Time Allowed</div>
	                                <div class="C">
	                                    <div id="clockdiv">
	                                        <div>
	                                            <span class="hours">00</span>
	                                            <div class="smalltext">HR</div>
	                                        </div>
	                                        <div>
	                                            <span class="minutes">30</span>
	                                            <div class="smalltext">MIN</div>
	                                        </div>
	                                        <div>
	                                            <span class="seconds">00</span>
	                                            <div class="smalltext">SEC</div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="thumb2-third">
	                            <div class="A">
	                                <div class="B">WI</div>
	                                <div class="C">Y</div>
	                            </div>
	                        </div>
	                        <div class="thumb3-first">
	                            <div class="A">
	                                <div class="B">LP</div>
	                                <div class="C">5th</div>
	                            </div>
	                        </div>
                            <div class="thumb3-second">
                                <div class="A">
                                    <div class="B">Candidates</div>
                                    <div class="C">11,500,000</div>
                                </div>
                            </div>
                            <div class="thumb3-third">
                                <div class="A">
                                    <div class="B">Switch To Questions</div>
                                    <div class="C">    
                                        <div id="btn-group">
                                    <?php
                                            $int = 0;
                                            $prId_array = array_column($problems, 'Id');
                                            foreach($prId_array as $problem)
                                            {
                                                $id = $prId_array[$int];
                                                if($number == $prId_array[$int])
                                                {
                                                    $active = 'active';
                                                    $qs_num = $int;
                                                } else {
                                                    $active = '';
                                                }
                                    ?>
                                            <div>
                                                <a class="<?=$active?>" href="<?=site_url("student/select/{$id}")?>"><?=$int + 1?></a>
                                            </div>
                                    <?php
                                                $int++;
                                            }
                                    ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- <div class="space-block"></div> -->
                    </div>
                </div>
            </div>
            <div class="problem-section bg-primary py-20pt">
                <div class="container page__container">
                    <!-- <div class="d-flex flex-wrap align-items-end">
                        <h2><span class="question-title"><?=$qs_num + 1?></span></h2>
                    </div> -->
                    <div>
                        <p class="text-white problem"><?=$showproblem->question?></p>
                        <p class="text-white problem mb-0"><?=$showproblem->explanation?></p>
                    </div>
                </div>
            </div>
            <div class="container page__container">
                <form method="post">
                    
                    <div class="pr-ref py-4">
                    <?php
                        if($showproblem->PR1)
                        {
                    ?>
                        <div class="ref-div">
                            <p class="ref">Picture Reference</p>
                        </div>
                        <div class="fancybox-div">
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR1)?>"  title="Picture Reference 1"> <div src="<?=base_url("assets/upload/".$showproblem->PR1)?>"  alt="" class="pr-images">PR1 </div></a>
                    <?php
                        }

                        if($showproblem->PR2)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR2)?>"  title="Picture Reference 2"> <div src="<?=base_url("assets/upload/".$showproblem->PR2)?>"  alt="" class="pr-images">PR2 </div></a>
                    <?php 
                        }

                        if($showproblem->PR3)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR3)?>"  title="Picture Reference 3"> <div src="<?=base_url("assets/upload/".$showproblem->PR3)?>"  alt="" class="pr-images">PR3 </div></a>
                    <?php 
                        }

                        if($showproblem->PR4)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR4)?>"  title="Picture Reference 4"> <div src="<?=base_url("assets/upload/".$showproblem->PR4)?>"  alt="" class="pr-images">PR4 </div></a>
                    <?php
                        }

                        if($showproblem->PR5)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR5)?>"  title="Picture Reference 5"> <div src="<?=base_url("assets/upload/".$showproblem->PR5)?>"  alt="" class="pr-images">PR5 </div></a>
                    <?php
                        }

                        if($showproblem->PR6)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR6)?>"  title="Picture Reference 6"> <div src="<?=base_url("assets/upload/".$showproblem->PR6)?>"  alt="" class="pr-images">PR6 </div></a>
                    <?php
                        }

                        if($showproblem->PR7)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR7)?>"  title="Picture Reference 7"> <div src="<?=base_url("assets/upload/".$showproblem->PR7)?>"  alt="" class="pr-images">PR7 </div></a>
                    <?php
                        }

                        if($showproblem->PR8)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR8)?>"  title="Picture Reference 8"> <div src="<?=base_url("assets/upload/".$showproblem->PR8)?>"  alt="" class="pr-images">PR8 </div></a>
                    <?php
                        }

                        if($showproblem->PR9)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR9)?>"  title="Picture Reference 9"> <div src="<?=base_url("assets/upload/".$showproblem->PR9)?>"  alt="" class="pr-images">PR9 </div></a>
                    <?php
                        }

                        if($showproblem->PR10)
                        {
                    ?>
                            <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->PR10)?>" title="Picture Reference 10"><div src="<?=base_url("assets/upload/".$showproblem->PR10)?>" alt="" class="pr-images">PR10</div></a>
                    <?php
                        }
                    ?>
                        </div>
                    </div>
                                            
                    <div class="page-section">
                        <div class="page-separator">
                            <div class="page-separator__text">Your Answer</div>
                        </div>

                    <?php
                        if($showproblem->A)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <input type="hidden" id="problemId" value="<?=$showproblem->Id?>">
                                        <span class="select1" data-value="A" value="A">A</span>
                                        <label class="answer-text select2" data-value="A"><?=$showproblem->A?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->B)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="B" value="B">B</span>
                                        <label class="answer-text select2" data-value="B"><?=$showproblem->B?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->C)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="C" value="C">C</span>
                                        <label class="answer-text select2" data-value="C"><?=$showproblem->C?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->D)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="D" value="D">D</span>
                                        <label class="answer-text select2" data-value="D"><?=$showproblem->D?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->E)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="E" value="E">E</span>
                                        <label class="answer-text select2" data-value="E"><?=$showproblem->E?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->F)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="F" value="F">F</span>
                                        <label class="answer-text select2" data-value="F"><?=$showproblem->F?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->G)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="G" value="G">G</span>
                                        <label class="answer-text select2" data-value="G"><?=$showproblem->G?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->H)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="H" value="H">H</span>
                                        <label class="answer-text select2" data-value="H"><?=$showproblem->H?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->I)
                        {
                    ?>
                            <div class="form-group">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="I" value="I">I</span>
                                        <label class="answer-text select2" data-value="I"><?=$showproblem->I?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }

                        if($showproblem->J)
                        {
                    ?>
                            <div class="form-group after">
                                <div id="each-answer">
                                    <div>
                                        <span class="select1" data-value="J" value="J">J</span>
                                        <label class="answer-text select2" data-value="J"><?=$showproblem->J?></label>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>
                            <div class="sr-ref">
                                <div class="form-group">
                                    <div class="page-separator">
                                        <div class="page-separator__text">SOLUTION DETAILS</div>
                                    </div>
                                    
                                    <p class="solution"><?=$showproblem->{$showproblem->correct}?></p>
                                </div>

                                <div class="sr-group">
                            <?php
                                if($showproblem->SR1)
                                {
                            ?>
                                    <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR1)?>" title="Solution Picture Reference 1"><div src="<?=base_url("assets/upload/".$showproblem->SR1)?>" class="sr-images">SR1</div></a>
                            <?php
                                }

                                if($showproblem->SR2)
                                {
                            ?>
                                    <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR2)?>" title="Solution Picture Reference 2"><div src="<?=base_url("assets/upload/".$showproblem->SR2)?>" class="sr-images">SR2</div></a>
                            <?php
                                }

                                if($showproblem->SR3)
                                {
                            ?>
                                    <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR3)?>" title="Solution Picture Reference 3"><div src="<?=base_url("assets/upload/".$showproblem->SR3)?>" class="sr-images">SR3</div></a>
                            <?php
                                }

                                if($showproblem->SR4)
                                {
                            ?>
                                    <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR4)?>" title="Solution Picture Reference 4"><div src="<?=base_url("assets/upload/".$showproblem->SR4)?>" class="sr-images">SR4</div></a>
                            <?php
                                }

                                if($showproblem->SR5)
                                {
                            ?>
                                    <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR5)?>" title="Solution Picture Reference 5"><div src="<?=base_url("assets/upload/".$showproblem->SR5)?>" class="sr-images">SR5</div></a>
                            <?php
                                }

                                if($showproblem->SR6)
                                {
                            ?>
                                    <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR6)?>" title="Solution Picture Reference 6"><div src="<?=base_url("assets/upload/".$showproblem->SR6)?>" class="sr-images">SR6</div></a>
                            <?php
                                }
                            ?>
                                    <a class="discuss" href="#"><i class="material-icons list-icon">group</i> &nbsp;Discuss in Forum</a>
                                </div>
                            </div>
                    </div>
                    <div class="navbar navbar-expand-md navbar-light border-bottom-2 ">
                        <div class="nav navbar-nav ml-sm-auto navbar-list__item">
                            <a href="<?=site_url("student/practice")?>" class="btn justify-content-center btn-accent w-100 w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt">Next <i class="material-icons icon--right">keyboard_arrow_right</i></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var $url = '<?=site_url()?>';
        var html = '<div class="sr-ref">' +
                        '<div class="form-group">' +
                            '<div class="page-separator">' +
                                '<div class="page-separator__text">SOLUTION DETAILS</div>' +
                            '</div>' +
                            
                            "<p class='solution'><?=$showproblem->{$showproblem->correct}?></p>" +
                        '</div>' +

                        '<div class="discuss-sr-group">' +
                            '<div class="sr-group">' +
                            <?php
                                if($showproblem->SR1)
                                {
                            ?>
                                    '<a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR1)?>" title="Solution Picture Reference 1"><div src="<?=base_url("assets/upload/".$showproblem->SR1)?>" class="sr-images">SR1</div></a>' +
                            <?php
                                }

                                if($showproblem->SR2)
                                {
                            ?>
                                    '<a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR2)?>" title="Solution Picture Reference 2"><div src="<?=base_url("assets/upload/".$showproblem->SR2)?>" class="sr-images">SR2</div></a>' +
                            <?php
                                }

                                if($showproblem->SR3)
                                {
                            ?>
                                    '<a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR3)?>" title="Solution Picture Reference 3"><div src="<?=base_url("assets/upload/".$showproblem->SR3)?>" class="sr-images">SR3</div></a>' +
                            <?php
                                }

                                if($showproblem->SR4)
                                {
                            ?>
                                    '<a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR4)?>" title="Solution Picture Reference 4"><div src="<?=base_url("assets/upload/".$showproblem->SR4)?>" class="sr-images">SR4</div></a>' +
                            <?php
                                }

                                if($showproblem->SR5)
                                {
                            ?>
                                    '<a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR5)?>" title="Solution Picture Reference 5"><div src="<?=base_url("assets/upload/".$showproblem->SR5)?>" class="sr-images">SR5</div></a>' +
                            <?php
                                }

                                if($showproblem->SR6)
                                {
                            ?>
                                    '<a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$showproblem->SR6)?>" title="Solution Picture Reference 6"><div src="<?=base_url("assets/upload/".$showproblem->SR6)?>" class="sr-images">SR6</div></a>' +
                            <?php
                                }
                            ?>
                            '</div>' +
                            '<div class="discuss-div">' +
                                '<a class="discuss" href="#"><i class="material-icons list-icon">group</i> &nbsp;Discuss in Forum</a>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
        var number = <?=$qs_num + 1?>;
    </script>