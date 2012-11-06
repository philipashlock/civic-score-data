<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> School Status Finder </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Le styles -->
  <link href="/mockup/css/bootstrap.css" rel="stylesheet">
  <link href="/mockup/css/bootstrap-responsive.css" rel="stylesheet">
  <link href="/mockup/css/styles.css" rel="stylesheet">

  <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <!-- Le fav and touch icons -->
  <link rel="shortcut icon" href="assets/ico/favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/mockup/assets/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/mockup/assets/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/mockup/assets/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="/mockup/assets/ico/apple-touch-icon-57-precomposed.png">
  
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
   <script src="/mockup/js/bootstrap.js"></script>
  <script>
  $(document).ready(function() {

  });
  </script>
</head>
<body>
  <div class="container">
  <!--header -->
  <header class="page-header span9 row">
    <div class="row">
    <a href="../mockup/index.html"><div id="logo" class="span6"><h1>School Status Finder</h1></div></a>
    <div class="span3">
      <a href="#aboutModal" role="button" class="btn btn-info" data-toggle="modal">About</a>
    </div>
    </div>
  </header>
  <?php
    if (!empty($entity)) {
	?>
  <div id="schoolinfo" class="span9">
     <div class="row">
       <div id="schoolName" class="span6">
         <h3><?php echo $entity['full_name']; ?></h3>
         <address>
           <h4>Address:</h4><br/>
           <?php echo $entity['location_address']; ?><br/>
           <?php echo $entity['location_city']; ?>, <?php echo $entity['location_state']; ?> <?php echo $entity['location_zip']; ?><br/>
           <p><a href="https://maps.google.com/?q=<?php echo $entity['latitude']; ?><?php echo $entity['longitude']; ?>"View on a map</p>
           <h4>Phone:</h4> <?php if (isset($entity['phone'])) echo $entity['phone']; ?><br/>
         </address>
       </div>
       <div class="span3">
         <a href="../status/school/<?php echo $entity['id_nces']; ?>" role="button" class="btn btn-success"><i class="icon-star icon-white"></i>  Submit Data</a>
       </div>
     </div>
	<?php if (!empty($status['status'])): ?>
     <div id="status">
       <h3>Status</h3>
       <p><?php echo $status['status']; ?></p>
     </div>
	<?php else : ?>
     <div id="status">
       <h3>No Status Info</h3>
     </div>
	<?php endif ?>
     <div id="details">
       <h3>Details</h3>
       <table class="table">
         <th>Accessibility</th>
         <th>Needs and Damages</th>
       </table>
     </div>
  </div>
    </div>
  <?php
  }
  ?>

  <!--about modal -->
  <div id="aboutModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="aboutModalLabel">About School Status Finder</h3>
    </div>
    <div class="modal-body">
      <p>This tool was developed by:</p>
      <ul>
        <li>Philip Ashlock: server-side and database</li>
        <li><a href="http://about.me/ashley_williams">Ashley Williams: client-side/frontend</a></li>
        <li>Ryan Panchadsaram: project management, FEMA/DOE coordinator</li>
        <li>Noel Hidalgo: NYTM and #hurricanehackers liason</li>
      </ul>
      <p>This tool was one project, among many, inspired by the work of <a href="http://hurricanehackers.com">#HurricaneHackers</a>, a distributed team of international volunteers working alongside the <a href="http://nytm.org">New York Tech Meetup (NYTM)</a>. For more information, <a href="http://hurricanehackers.com">click here</a>.<br/><br/>Made lovingly with <a href="http://twitter.github.com/bootstrap/">Twitter Bootstrap</a> and <a href="http://jquery.com">jQuery</a>.</p>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
  </div>
  </div>
</body>
</html>