<?php
include 'header.php';
?>

<div class='container mt-3'>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv kredita</th>
                <th>Godisnja kamatna stopa</th>
                <th>Minimalna primanja</th>
                <th>Minimalni period zaposlenja</th>
                <th>Minimalni iznos</th>
                <th>Maksimalni iznos</th>
                <th>Minimalni period otplate</th>
                <th>Maksimalni period otplate</th>
            </tr>
        </thead>
        <tbody id='krediti'>

        </tbody>
    </table>

</div>
<script>
    $(document).ready(function() {
        $.getJSON('./server/index.php', {
            akcija: 'vratiKredite'
        }, function(res) {
            if (!res.status) {
                alert(res.error);
                return;
            }
            for (let kredit of res.data) {
                $('#krediti').append(`
                <tr>
                    <td>${kredit.id}</td>
                    <td>${kredit.naziv}</td>
                    <td>${kredit.kamatna_stopa}</td>
                    <td>${kredit.minimun_primanja}</td>
                    <td>${kredit.minimum_zaposlen}</td>
                    <td>${kredit.minimalni_iznos}</td>
                    <td>${kredit.maksimalni_iznos}</td>
                    <td>${kredit.minimalni_period}</td>
                    <td>${kredit.maksimalni_period}</td>
                </tr>
            `)
            }
        })
    })
</script>
<?php
include 'footer.php';
?>