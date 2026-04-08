<?= $this->include('template/header'); ?>

<h2><?= $artikel['judul']; ?></h2>
<p><?= nl2br($artikel['isi']); ?></p>
<p><a href="/artikel">&laquo; Kembali</a></p>

<?= $this->include('template/footer'); ?>