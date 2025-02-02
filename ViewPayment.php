<?php
include 'db.php';
session_start();

$payment_detail_query="select u.username, p.match_id, p.payment_time, p.payment_status, p.payment_method from users u 
join payment p on p.user_id=u.id";

$payment_detail_stmt = $pdo->query($payment_detail_query);
$payments=$payment_detail_stmt->fetchAll(PDO::FETCH_ASSOC);

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Payment Table</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">User Payment Details</h2>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">Match ID</th>
          <th scope="col">Player Name</th>
          <th scope="col">Payment Status</th>
          <th scope="col">Payment Method</th>
        </tr>
      </thead>
      <tbody>
        <!-- Dynamic rows will go here -->
         <?php foreach($payments as $payment):?>
        <tr>
          <td><?php echo $payment['match_id']?></td>
          <td><?php echo $payment['username']?></td>
          <td><?php echo $payment['payment_status']?></td>
          <td><?php echo $payment['payment_method']?></td>
        </tr>
       <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap JS (optional, if you need Bootstrap's JS features) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>