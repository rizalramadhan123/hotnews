<?php
/** @var array $articles */
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="row g-4" style="background-color: D3D3D3;">

    <!-- Sidebar Top 10 Berita -->
    
    <aside class="col-md-3 col-lg-2 bg-white shadow-sm rounded p-3">
    <h5 class="mb-3 fw-bold text-dark">Top 10 Berita Hari Ini</h5>

    <ul class="list-group list-group-flush">
        <?php foreach(array_slice($articles, 0, 10) as $article): ?>
            <li class="list-group-item border-bottom py-2 px-0 d-flex align-items-start">
                <div class="flex-grow-1">
                    <?= Html::a(
                            Html::encode($article['title'] ?? $article['source']['name']),
                            'javascript:void(0)',
                            ['class' => 'text-dark text-decoration-none fw-semibold']
                        ) ?>

                    <small class="d-block text-muted mt-1"><?= $article['source']['name'] ?? '' ?></small>
                </div>
                <?php if(!empty($article['urlToImage'])): ?>
                    <img src="<?= $article['urlToImage'] ?>" class="rounded ms-2" alt="thumbnail" style="width: 50px; height:50px; object-fit:cover;">
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>

    <!-- Main Content -->
   <main class="col-md-9 col-lg-10">

   <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
          <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="javascript:void(0)" onclick="nav_function(1)">Search</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="javascript:void(0)" onclick="nav_function(2)">Categories</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>

    <!-- Search Box dengan Select Kategori -->
    <div class="mb-4">
        <form class="d-flex" method="get" onsubmit="return false;">
            <!-- Input Search -->
            <input class="form-control me-2" type="search" name="q" placeholder="Cari berita..." aria-label="Search" onkeyup="debouncedCariData()">

            <!-- Select Kategori -->
            <select class="form-select me-2" name="category" aria-label="Pilih kategori" style="display: none;" onchange="cariData()">
                <option value="">Pilih Category</option>
                <?php foreach(array_slice($categories, 0, 10) as $index => $categorie): ?>
                    <option value="<?= $index; ?>"><?= $categorie; ?></option>
                <?php endforeach; ?>
            </select>

        </form>
    </div>

    <!-- Spinner Loading -->
    <div id="loadingSpinner" class="text-center my-4" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- List Berita dalam Card -->
    <section class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="list_news">
            
    </section>
</main>


</div>
<script>
let timeout;

    function debouncedCariData() {
        clearTimeout(timeout); 
        timeout = setTimeout(() => {
            cariData(); 
        }, 500); 
    }

function cariData() {
    // Tampilkan spinner
    $('#loadingSpinner').show();
    $('#list_news').hide(); // sembunyikan list sementara

    $.ajax({
        url: 'news/search',
        type: 'POST',
        data: {
            'q': $('input[name="q"]').val(),
            'category': $('select[name="category"]').val(),
        },
        success: (response) => {
            let data = JSON.parse(response);
            let html = '';
            for (let key in data) {
                html += `
                    <div class="col">
                        <div class="card h-100 shadow-sm rounded overflow-hidden">
                            <img src="${data[key].urlToImage}" class="card-img-top" alt="${data[key].title}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">${data[key].title}</h5>
                                <p class="card-text flex-grow-1 text-truncate">${data[key].description}</p>
                                <a href="${data[key].url}" class="btn btn-primary mt-2">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>`;
            }
            $('#list_news').html(html);

            // Sembunyikan spinner dan tampilkan list berita
            $('#loadingSpinner').hide();
            $('#list_news').show();
        },
        error: () => {
            $('#loadingSpinner').hide();
            alert('Terjadi kesalahan saat memuat berita.');
        }
    });
}


    function nav_function(x){
        if(x == 1){
            $('input[name="q"]').css('display','');
            $('select[name="category"]').css('display','none');
            $('select[name="category"]').val('');
        }else if(x == 2){
            $('input[name="q"]').css('display','none');
            $('input[name="q"]').val('');
            $('select[name="category"]').css('display','');
        }
    }
</script>

