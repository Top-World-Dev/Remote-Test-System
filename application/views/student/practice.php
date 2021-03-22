<div class="page-section bg-alt border-bottom-2 pt-3 pb-2">
    <div class="container page__container">
        <div class="status-panel text-center">
            <!-- <div class="space-block"></div> -->
            <div class="thumb1-first">
                <div class="A">
                    <div class="progress-bar-linkedin progress-bar-animated" role="progressbar">Answered Correctly 85%</div>
                    <div class="B">THE THEORY OF DEMAND & SUPPLY QUESTION NO: 03
                    </div>
                </div>
            </div>
            <div class="thumb1-second simple">
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
            <div class="thumb2-second">
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
            <div class="thumb2-third simple">
                <div class="A">
                    <div class="B">WI</div>
                    <div class="C">Y</div>
                </div>
            </div>
            <div class="thumb3-first simple">
                <div class="A">
                    <div class="B">LP</div>
                    <div class="C">5th</div>
                </div>
            </div>
            <div class="thumb3-second simple">
                <div class="A">
                    <div class="B">Candidates</div>
                    <div class="C">11,500,000</div>
                </div>
            </div>
            <div class="thumb3-third">
                <div class="A">
                    <div class="B">Switch To Questions</div>
                    <div class="C">
                        <div class="switch-buttons" id="btn-group">
                            <?php
                            $i = 0;
                            $prId_array = array_column($problems, 'Id');
                            foreach ($prId_array as $problem) {
                                $id = $prId_array[$i];
                                if ($i == 0)
                                    $active = 'active';
                                else
                                    $active = ''; ?>
                                <button class="<?= $active ?>" data-id="<?= $id ?>"><?= $i + 1 ?></button>
                            <?php
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-section problem-section bg-primary py-20pt">
    <div class="container page__container">
        <div class="question my-2">
            <?= $showproblem->question ?>
        </div>
    </div>
</div>
<div class="page-section py-2">
    <div class="container page__container">
        <div class="pr-ref py-4">
            <div class="ref-div">
                <p class="ref">Picture Reference</p>
            </div>
            <div class="fancybox-div">
                <?php
                $isPictureRef = false;
                for ($i = 1; $i <= 10; $i++) {
                    $prname = "PR$i";
                    if ($showproblem->{$prname}) { ?>
                        <a class="fancybox" rel="gallery1" href="<?= base_url("assets/upload/" . $showproblem->{$prname}) ?>" title="Picture Reference <?= $i ?>">
                            <div src="<?= base_url("assets/upload/" . $showproblem->{$prname}) ?>" alt="" class="pr-images"><?= $prname ?></div>
                        </a>
                <?php
                        $isPictureRef = true;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="page-section py-0">
    <div class="container page__container">
        <div class="page-separator">
            <div class="page-separator__text">Your Answer</div>
        </div>
        <input type="hidden" id="problemId" value="<?= $showproblem->Id ?>">
        <div class="answer-group">
            <?php
            $answers = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            foreach ($answers as $answer) {
                if ($showproblem->{$answer}) {
            ?>
                    <div class="form-group">
                        <div class="each-answer">
                            <div>
                                <span class="select1" data-value="<?= $answer ?>" value="<?= $answer ?>"><?= $answer ?></span>
                                <label class="answer-text select2" data-value="<?= $answer ?>"><?= $showproblem->{$answer} ?></label>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<div class="page-section">
    <div class="container page__container">
        <div class="sr-ref">
        </div>
        <div class="page-separator">
            <div class="page-separator__text"></div>
        </div>
        <div class="form-group mt-2 text-right">
            <button class="btn justify-content-center btn-accent w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt next">Next <i class="material-icons icon--right">keyboard_arrow_right</i></button>
        </div>
    </div>
</div>
<script>
    <?php
    if (!$isPictureRef) { ?>
        $('.pr-ref').hide();
    <?php
    }
    ?>
</script>