<!-- Header Layout -->
<div class="mdk-header-layout js-mdk-header-layout" data-domfactory-upgraded="mdk-header-layout">
    <!-- Header -->
    <div class="mdk-header-layout__content page-content">
        <div class="page-section bg-alt pt-3 pb-0">
            <div class="container page__container">
                <div class="switch-block text-right">
                    <label class="form-label mb-0" for="mode">Practicing</label>
                    <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                        <input type="checkbox" id="mode" class="custom-control-input" value="<?=$type?>" <?=$type == "Practicing"?'':'checked'?>>
                        <label class="custom-control-label" for="mode">&nbsp;</label>
                    </div>
                    <label class="form-label mb-0" for="mode">Examination</label>
                </div>
            </div>
        </div>
        <div class="page-section bg-alt border-bottom-2 pt-3 pb-2">
            <div class="container page__container">
                <div class="status-panel text-center">
                    <!-- <div class="space-block"></div> -->
                    <div class="thumb1-first">
                        <div class="A">
                            <div class="progress-bar-linkedin progress-bar-animated" role="progressbar">Answered Correctly 85%</div>
                            <div class="B">THE THEORY OF DEMAND & SUPPLY QUESTION NO: <?=$problem['question_number']?></div>
                        </div>
                    </div>
                    <div class="thumb1-second simple">
                        <div class="A">
                            <div class="B">SQ</div>
                            <div class="C"><?=($problem['type'] == 'PS' || $problem['type'] == 'GC' || $problem['type'] == 'WWC') ? $problem['sq'] : '-'?></div>
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
                                        <span class="hours"><?=$allowed['format'][0]?></span>
                                        <div class="smalltext">HR</div>
                                    </div>
                                    <div>
                                        <span class="minutes"><?=$allowed['format'][1]?></span>
                                        <div class="smalltext">MIN</div>
                                    </div>
                                    <div>
                                        <span class="seconds"><?=$allowed['format'][2]?></span>
                                        <div class="smalltext">SEC</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="thumb2-third simple">
                        <div class="A">
                            <div class="B">WI</div>
                            <div class="C"><?=$problem['type'] == 'PS' || $problem['type'] == 'GC' ? ($dropbox['winner_indication'] ? 'Y':'N'):'-'?></div>
                        </div>
                    </div>
                    <div class="thumb3-first simple">
                        <div class="A">
                            <div class="B">LP</div>
                        <?php
                            $displayPos = "{$position}th";
                            if ($position == 1)
                                $displayPos = "1st";
                            else if ($position == 2) 
                                $displayPos = "2nd";
                            else if ($position == 3)
                                $displayPos = "3rd";
                        ?>
                            <div class="C"><?=$displayPos?></div>
                        </div>
                    </div>
                    <div class="thumb3-second simple">
                        <div class="A">
                            <div class="B">Candidates</div>
                            <div class="C"><?=$problem['type'] == 'PS' || $problem['type'] == 'GC' || $problem['type'] == 'WWC' ? number_format($position) : '-'?></div>
                        </div>
                    </div>
            <?php
                $problemIds = array_column($problems, 'Id');
                if ($type == "Practicing") { ?>
                    <div class="thumb3-third">
                        <div class="A">
                            <div class="B">Switch To Questions</div>
                            <div class="C">    
                                <div class="switch-buttons" id="btn-group">
                            <?php
                                foreach($problemIds as $key => $id)
                                {
                                    $active = $key == 0 ? 'active' : ''; ?>
                                    <button class="<?=$active?>" data-id="<?=$id?>"><?=$key + 1?></button>
                                    <?php
                                }
                            ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else { ?>
                    <input type="hidden" id="plist" value="<?=implode(",", $problemIds)?>">
                    <?php
                }
            ?>
                </div>
            </div>
        </div>
        <div class="page-section problem-section bg-primary py-20pt">
            <div class="container page__container">
                <div class="question my-2">
                    <?=$problem['question']?>
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
                for($i = 1; $i <= 10; $i++) {
                    if($problem['PR'.$i]) { ?>
                        <a class="fancybox" rel="gallery1" href="<?=base_url("assets/upload/".$problem['PR'.$i])?>"  title="Picture Reference <?=$i?>"> 
                            <div src="<?=base_url("assets/upload/".$problem['PR'.$i])?>"  alt="" class="pr-images">PR<?=$i?></div>
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
                <input type="hidden" id="ptype" name="ptype" value="<?=$problem['type']?>">
                <input type="hidden" id="dropboxId" name="dropboxId" value="<?=$dropbox['Id']?>">
                <input type="hidden" id="problemId" name="problemId" value="<?=$problem['Id']?>">
                <div class="answer-group">
        <?php
            $answers = ['A','B','C','D','E','F','G','H','I','J'];
            foreach ($answers as $answer) {
                if($problem[$answer]) { ?>
                    <div class="form-group">
                        <div class="each-answer">
                            <div>
                                <span class="select1" data-value="<?=$answer?>" value="<?=$answer?>"><?=$answer?></span>
                                <label class="answer-text select2" data-value="<?=$answer?>"><?=$problem[$answer]?></label>
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
                <div class="sr-ref"></div>
                <div class="page-separator"><div class="page-separator__text"></div></div>
                <div class="form-group mt-2 text-right">
                    <button class="btn btn-accent w-sm-auto mb-16pt mb-sm-0 ml-sm-16pt next" <?=$type == "Practicing"?'':'disabled'?>>
                        Next <i class="material-icons icon--right">keyboard_arrow_right</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-sm" id="summary_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form mothod="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mySmallModalLabel">Summary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body px-0 py-0">
                    <div class="card mb-0">
                        <div class="card-header d-flex align-items-center">
                            <div class="flex">
                                <h4 class="card-title"><?=$type?> Mode</h4>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="#" class="text-body d-flex align-items-center">
                                    <strong class="flex" class="module-title">General Physics</strong> 
                                    <span></span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-body d-flex align-items-center">
                                    <strong class="flex">Time Allowed</strong> 
                                    <span class="time-allowed">100 Minutes</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-body d-flex align-items-center">
                                    <strong class="flex">Time Spent</strong> 
                                    <span class="time-spent">100 Minutes</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-body d-flex align-items-center">
                                    <strong class="flex">Total number of questions</strong> 
                                    <span class="total-questions">5</span>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="#" class="text-body d-flex align-items-center">
                                    <strong class="flex">Number of questions answer correctly</strong> 
                                    <span class="corrects">5</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="progress-back" style="display:none;">
    <div class="progress-wrap">
        <div class="progress mb-16pt">
            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="progress-text">Loading problem...</div>
    </div>
</div>
<script>
var elapsed = 0;
<?php
if (!$isPictureRef) { ?>
    $('.pr-ref').hide();
    <?php
}
?>
</script>