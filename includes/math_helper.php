<?php
require_once('helper.php');
require_once('db.php');

function sqlRTMean($iatId, $block) {
  if (!(is_int($block) && is_int($iatId)))
    return "ARG_ERROR";
  return "(SELECT Avg(response_time*1000.0) FROM trials WHERE response_time < 10.0 AND iat_id=$iatId AND block=$block AND error=0)";
}

function sqlNumTrials($iatId, $block) {
  if (!(is_int($block) && is_int($iatId)))
    return "ARG_ERROR";
  return "(SELECT (SELECT count(*) FROM trials WHERE response_time < 10.0 AND iat_id=$iatId AND block=$block))";
}

function sqlNumErrors($iatId, $block) {
  if (!(is_int($block) && is_int($iatId)))
    return "ARG_ERROR";
  return "(SELECT (SELECT count(*) FROM trials WHERE response_time < 10.0 AND iat_id=$iatId AND block=$block AND error=1))";
}

function sqlCorrectTrials($iatId, $block) {
  if (!(is_int($block) && is_int($iatId)))
    return "ARG_ERROR";
  return "(SELECT response_time*1000.0 as response_time from trials"
      . " WHERE response_time < 10.0 AND iat_id=$iatId AND block=$block AND error=0)";
}

function sqlAdjustedTrials($iatId, $block) {
  if (!(is_int($block) && is_int($iatId)))
    return "ARG_ERROR";
  $correctMean = sqlRTMean($iatId, $block);
  //$adjustedMean = sqlAdjustedMean($iatId, $block);
  return "(SELECT $correctMean+600.0 FROM (SELECT * FROM trials"
    . " WHERE iat_id=$iatId AND block=$block AND error=1) AS temp)";
}

// Returns the sample variance of all trials for a block
function sqlBlockVar($iatId, $block) {
  if (!(is_int($block) && is_int($iatId)))
    return "ARG_ERROR";
  $correctTrials = sqlCorrectTrials($iatId, $block);
  $adjustedTrials = sqlAdjustedTrials($iatId, $block);
  return "(SELECT Var_samp(response_time) FROM ($correctTrials UNION ALL $adjustedTrials) AS all_adjusted_trials)";
}

function sqlCombinedStdDev($iatId, $block1, $block2) {
  if (!(is_int($block1) && is_int($block2) && is_int($iatId)))
    return "ARG_ERROR";
  $correctTrials1 = sqlCorrectTrials($iatId, $block1);
  $adjustedTrials1 = sqlAdjustedTrials($iatId, $block1);
  $correctTrials2 = sqlCorrectTrials($iatId, $block2);
  $adjustedTrials2 = sqlAdjustedTrials($iatId, $block2);
  return "(SELECT Stddev_samp(response_time) FROM ($correctTrials1 UNION ALL $adjustedTrials1"
  . " UNION ALL $correctTrials2 UNION ALL $adjustedTrials2) AS totatl_stddev)";
}

// Calculates the mean with the errors
function sqlAdjustedMean($iatId, $block) {
  if (!(is_int($block) && is_int($iatId)))
    return "ARG_ERROR";
  $mean = sqlRTMean($iatId, $block);
  $numTrials = sqlNumTrials($iatId, $block);
  $numErrors = sqlNumErrors($iatId, $block);
  // If you look at how errors are handeled it reduces to
  // correct_trials_mean + (0.6 * num_errors/num_trials)
  return "(SELECT $mean + (600.0 * ($numErrors/$numTrials)))";
  //return "(SELECT $mean + (.6 * ($numErrors/$numTrials)))";
}

function sqlPooledStdDev($iatId, $block1, $block2) {
  if (!(is_int($block1) && is_int($block2) && is_int($iatId)))
    return "ARG_ERROR";
  $var1 = sqlBlockVar($iatId, $block1);
  $var2 = sqlBlockVar($iatId, $block2);
  $numTrials1 = sqlNumTrials($iatId, $block1);
  $numTrials2 = sqlNumTrials($iatId, $block2);
  return "(SELECT sqrt(($var1 * ($numTrials1-1) + $var2 * ($numTrials2-1))/($numTrials1+$numTrials2-2)) AS pooled_sd)";
}

function sqlPairScore($iatId, $block1, $block2, $usePooled = true) {
  if (!(is_int($block1) && is_int($block2) && is_int($iatId)))
    return "ARG_ERROR";
  $mean1 = sqlAdjustedMean($iatId, $block1); 
  $mean2 = sqlAdjustedMean($iatId, $block2); 
  if ($usePooled)
    $stddev= sqlPooledStdDev($iatId, $block1, $block2);
  else
    $stddev= sqlCombinedStdDev($iatId, $block1, $block2);
  return "(SELECT ($mean2 - $mean1)/$stddev AS pair_score)";
}

function sqlFinalScore($iatId, $pair1, $pair2, $usePooled = true) {
  $pairScore1 = sqlPairScore($iatId, $pair1[0], $pair1[1], $usePooled);
  $pairScore2 = sqlPairScore($iatId, $pair2[0], $pair2[1], $usePooled);
  return "(SELECT ($pairScore1 + $pairScore2)/2 AS final_score)";
}

// These are all for DEBUGGING purposes
//echo sqlAdjustedTrials(222, 3);
//echo sqlCorrectTrials(222, 3);
//echo sqlBlockVar(222, 3);
//echo sqlPooledStdDev(222, 4, 7);
//echo sqlPooledStdDev(222, 3, 6);
//echo sqlCombinedStdDev(222, 3, 6);
//echo sqlPairScore(222, 4, 7);
//echo sqlPairScore(222, 3, 6);
//echo sqlFinalScore(222, array(3,6), array(4,7), false);

?>
