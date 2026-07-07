<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
        <i class="bi bi-grid"></i>
        <span>Home</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="/keranjang">
        <i class="bi bi-cart-check"></i>
        <span>Keranjang</span>
      </a>
    </li>
    <!-- End Keranjang Nav -->
    <?php
    if (session()->get('role') == 'admin') {
    ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="/produk">
          <i class="bi bi-receipt"></i>
          <span>Produk</span>
        </a>
      </li>
      <!-- End Produk Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'diskon') ? "" : "collapsed" ?>" href="/diskon">
          <i class="bi bi-percent"></i>
          <span>Diskon</span>
        </a>
      </li>
      <!-- End Diskon Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'kelola-transaksi') ? "" : "collapsed" ?>" href="/kelola-transaksi">
          <i class="bi bi-clipboard-check"></i>
          <span>Kelola Transaksi</span>
        </a>
      </li>
      <!-- End Kelola Transaksi Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'history') ? "" : "collapsed" ?>" href="history">
          <i class="bi bi-person"></i>
          <span>History</span>
        </a>
      </li><!-- End History Nav -->

    <?php
    }
    ?>

  </ul>
</aside>
<!-- End Sidebar-->