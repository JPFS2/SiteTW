<?php
// Cookies.php — controle e exibição do banner de cookies

if (!isset($_COOKIE['termos_uso'])) {
    $mostrar_banner = true;
} else {
    $mostrar_banner = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cookie_acao'])) {
    $acao = $_POST['cookie_acao'] === 'aceitar' ? 'aceito' : 'rejeitado';
    setcookie('termos_uso', $acao, time() + (365*24*60*60), "/");
    // Para evitar reenvio do formulário:
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<?php if ($mostrar_banner): ?>
<style>
    /* Banner fixo e sobreposto no rodapé */
    #cookie-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
        box-shadow: 0 -3px 8px rgb(0 0 0 / 0.1);
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1050; /* bem acima do resto */
        transform: translateY(100%);
        opacity: 0;
        transition: transform 0.5s ease, opacity 0.5s ease;
        font-family: Arial, sans-serif;
    }
    #cookie-banner.show {
        transform: translateY(0);
        opacity: 1;
    }
</style>

<div id="cookie-banner">
    <div>
        <strong>Este site usa cookies</strong> para melhorar sua experiência. Aceita os termos de uso?
    </div>
    <form id="cookie-form" method="post" style="margin:0;">
        <input type="hidden" name="cookie_acao" id="cookie_acao" value="" />
        <button type="button" class="btn btn-primary btn-sm me-2" onclick="aceitarCookies()">Aceitar</button>
        <button type="button" class="btn btn-secondary btn-sm" onclick="rejeitarCookies()">Rejeitar</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const banner = document.getElementById('cookie-banner');
        // Mostra o banner com animação
        setTimeout(() => {
            banner.classList.add('show');
        }, 300);

        function sumirBanner() {
            banner.classList.remove('show');
            // Remove do fluxo após animação
            setTimeout(() => {
                banner.style.display = 'none';
            }, 500);
        }

        window.aceitarCookies = function() {
            document.getElementById('cookie_acao').value = 'aceitar';
            document.getElementById('cookie-form').submit();
        }

        window.rejeitarCookies = function() {
            document.getElementById('cookie_acao').value = 'rejeitar';
            document.getElementById('cookie-form').submit();
        }
    });
</script>

<!-- Bootstrap CSS (opcional, para estilizar os botões) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<?php endif; ?>
