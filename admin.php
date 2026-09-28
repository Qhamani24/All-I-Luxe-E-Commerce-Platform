<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminLogin.php");
    exit();
}

include 'db.php';

// Fetch stats
$totalSellers   = $conn->query("SELECT COUNT(*) AS cnt FROM sellers")->fetch_assoc()['cnt'] ?? 0;
$activeListings = $conn->query("SELECT COUNT(*) AS cnt FROM furniture WHERE status = 'active'")->fetch_assoc()['cnt'] ?? 0;
$pendingCount   = $conn->query("SELECT COUNT(*) AS cnt FROM furniture WHERE status = 'pending'")->fetch_assoc()['cnt'] ?? 0;
$totalSales     = $conn->query("SELECT SUM(price) AS total FROM orders WHERE status = 'completed'")->fetch_assoc()['total'] ?? 0;

// Format total sales
function formatRands($val) {
    if ($val >= 1000) return 'R' . round($val / 1000) . 'k';
    return 'R' . number_format($val);
}

// Fetch pending approvals
$pendingItems = $conn->query("
    SELECT f.id, f.itemName, f.brand, f.material, f.condition, f.image_path,
           s.firstName, s.lastName
    FROM furniture f
    JOIN sellers s ON f.seller_id = s.id
    WHERE f.status = 'pending'
    ORDER BY f.created_at DESC
    LIMIT 5
");

// Fetch monthly listings for chart
$monthlyData = [];
for ($m = 1; $m <= 6; $m++) {
    $res = $conn->query("SELECT COUNT(*) AS cnt FROM furniture WHERE MONTH(created_at) = $m AND YEAR(created_at) = YEAR(CURDATE())");
    $monthlyData[] = $res->fetch_assoc()['cnt'] ?? 0;
}
$maxMonthly = max($monthlyData) ?: 1;
$months = ['Jan','Feb','Mar','Apr','May','Jun'];

// Fetch recent orders
$recentOrders = $conn->query("
    SELECT o.id, o.amount, o.status, o.created_at,
           f.itemName,
           b.firstName AS buyerFirst, b.lastName AS buyerLast
    FROM orders o
    JOIN furniture f ON o.furniture_id = f.id
    JOIN buyers b ON o.buyer_id = b.id
    ORDER BY o.created_at DESC
    LIMIT 5
");

// Handle approve/reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id     = (int)$_GET['id'];
    $action = $_GET['action'];
    if ($action === 'approve') {
        $conn->query("UPDATE furniture SET status = 'active' WHERE id = $id");
    } elseif ($action === 'reject') {
        $conn->query("UPDATE furniture SET status = 'rejected' WHERE id = $id");
    }
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All I Luxe | Admin</title>
  <link rel="stylesheet" href="admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Lora&display=swap" rel="stylesheet">
</head>
<body>

<div class="admin-wrap">

  <!-- ── Sidebar ── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <span class="brand-name">All I Luxe</span>
      <span class="brand-sub">Admin Panel</span>
    </div>

    <nav class="sidebar-nav">
      <p class="nav-label">Main</p>
      <a href="admin.php" class="nav-item active">
        <span class="nav-icon">&#9645;</span> Dashboard
      </a>
      <a href="adminApprovals.php" class="nav-item">
        <span class="nav-icon">&#9645;</span> Approvals
        <?php if ($pendingCount > 0): ?>
          <span class="nav-badge"><?php echo $pendingCount; ?></span>
        <?php endif; ?>
      </a>

      <p class="nav-label">Manage</p>
      <a href="adminListings.php" class="nav-item">
        <span class="nav-icon">&#9645;</span> Listings
      </a>
      <a href="adminSellers.php" class="nav-item">
        <span class="nav-icon">&#9645;</span> Sellers
      </a>
      <a href="adminOrders.php" class="nav-item">
        <span class="nav-icon">&#9645;</span> Orders
      </a>
    </nav>

    <div class="sidebar-footer">
      <a href="adminSettings.php" class="nav-item">
        <span class="nav-icon">&#9645;</span> Settings
      </a>
    </div>
  </aside>

  <!-- ── Main ── -->
  <div class="main">

    <!-- Topbar -->
    <header class="topbar">
      <h1 class="topbar-title">Dashboard</h1>
      <div class="topbar-right">
        <?php if ($pendingCount > 0): ?>
          <a href="adminApprovals.php" class="pending-badge">
            &#9645; <?php echo $pendingCount; ?> pending
          </a>
        <?php endif; ?>
        <div class="avatar">A</div>
        <a href="adminLogout.php" class="logout-link">Log out</a>
      </div>
    </header>

    <!-- Content -->
    <div class="content">

      <!-- Stat cards -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon">&#128100;</div>
          <div class="stat-val"><?php echo $totalSellers; ?></div>
          <div class="stat-label">Total sellers</div>
          <div class="stat-change up">&#8599; +3 this week</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">&#128716;</div>
          <div class="stat-val"><?php echo $activeListings; ?></div>
          <div class="stat-label">Active listings</div>
          <div class="stat-change up">&#8599; +12 this week</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">&#9203;</div>
          <div class="stat-val"><?php echo $pendingCount; ?></div>
          <div class="stat-label">Pending approval</div>
          <div class="stat-change <?php echo $pendingCount > 0 ? 'warn' : 'up'; ?>">
            <?php echo $pendingCount > 0 ? '&#9888; Needs review' : '&#10003; All clear'; ?>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon">&#128178;</div>
          <div class="stat-val"><?php echo formatRands($totalSales); ?></div>
          <div class="stat-label">Total sales value</div>
          <div class="stat-change up">&#8599; +R12k this month</div>
        </div>
      </div>

      <!-- Middle row -->
      <div class="mid-row">

        <!-- Pending approvals panel -->
        <div class="panel panel-approvals">
          <div class="panel-head">
            <h2>Pending approvals</h2>
            <a href="adminApprovals.php" class="view-all">View all &rarr;</a>
          </div>

          <?php if ($pendingItems && $pendingItems->num_rows > 0): ?>
            <?php while ($item = $pendingItems->fetch_assoc()): ?>
              <div class="approval-item">
                <div class="approval-thumb">
                  <?php if (!empty($item['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['itemName']); ?>">
                  <?php else: ?>
                    <span>&#128716;</span>
                  <?php endif; ?>
                </div>
                <div class="approval-info">
                  <p class="approval-name"><?php echo htmlspecialchars($item['brand'] . ' ' . $item['itemName']); ?></p>
                  <p class="approval-sub">
                    by <?php echo htmlspecialchars($item['firstName'] . ' ' . $item['lastName']); ?>
                    &middot; <?php echo htmlspecialchars($item['material']); ?>
                    &middot; <?php echo htmlspecialchars($item['condition']); ?>
                  </p>
                </div>
                <div class="approval-actions">
                  <a href="admin.php?action=approve&id=<?php echo $item['id']; ?>" class="btn-approve">Approve</a>
                  <a href="admin.php?action=reject&id=<?php echo $item['id']; ?>"  class="btn-reject">Reject</a>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="no-items">No pending approvals &#10003;</p>
          <?php endif; ?>
        </div>

        <!-- Chart panel -->
        <div class="panel panel-chart">
          <div class="panel-head">
            <h2>Listings this month</h2>
          </div>
          <div class="bar-chart">
            <?php foreach ($monthlyData as $i => $val): ?>
              <div class="bar-wrap">
                <div class="bar <?php echo ($i === 5) ? 'bar-current' : ''; ?>"
                     style="height: <?php echo round(($val / $maxMonthly) * 100); ?>px"
                     title="<?php echo $months[$i] . ': ' . $val; ?>">
                </div>
                <span class="bar-lbl"><?php echo $months[$i]; ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>

      <!-- Recent orders -->
      <div class="panel panel-orders">
        <div class="panel-head">
          <h2>Recent orders</h2>
          <a href="adminOrders.php" class="view-all">View all &rarr;</a>
        </div>

        <table class="data-table">
          <thead>
            <tr>
              <th>Order</th>
              <th>Item</th>
              <th>Buyer</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($recentOrders && $recentOrders->num_rows > 0): ?>
              <?php while ($order = $recentOrders->fetch_assoc()): ?>
                <tr>
                  <td>#<?php echo $order['id']; ?></td>
                  <td><?php echo htmlspecialchars($order['itemName']); ?></td>
                  <td><?php echo htmlspecialchars($order['buyerFirst'] . ' ' . $order['buyerLast']); ?></td>
                  <td>R<?php echo number_format($order['amount']); ?></td>
                  <td>
                    <span class="status-pill s-<?php echo strtolower($order['status']); ?>">
                      <?php echo ucfirst($order['status']); ?>
                    </span>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" class="no-items">No orders yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /admin-wrap -->

</body>
</html>