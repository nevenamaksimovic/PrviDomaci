<?php
    include 'header.php';
?>

<div class="container mt-3">
    <h1 class="text-center">
        Zahtevi za kredit
    </h1>
    <div class="mt-2 mb-2">
        <input type="text" id='pretraga' placeholder="Pretrazi" class="form-control">
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    Kredit
                </th>
                <th>Korisnik</th>
                <th>Iznos</th>
                <th>Period otplate</th>
                <th>Kamatna stopa</th>
                <th>Rata</th>
                <th>Ukupan iznos otplate</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id='zahtevi'>

        </tbody>
    </table>
    <div>
        <h2>Kreiraj zahtev</h2>
        <form id='forma'>
            <label>Kredit</label>
            <select id="kredit" class="form-control"></select>
            <label>Korisnik</label>
            <select id="korisnik" class="form-control"></select>
            <label>Iznos kredita</label>
            <input class="form-control" type="number" min='0' id='iznos'>
            <label>Period otplate</label>
            <input class="form-control" type="number" min='0' id='period'>
            <button class="btn btn-primary" type="submit">Kreiraj</button>
        </form>
    </div>
</div>

<script>
    let zahtevi = [];

    $(document).ready(function () {
        ucitajZahteve();
        ucitajKredite();
        ucitajKorisnike();
        $('#pretraga').change(function () {
            popuniPodatke();
        })
        $('#forma').submit(function (e) {
            e.preventDefault();
            const kredit = $("#kredit").val();
            const korisnik = $("#korisnik").val();
            const iznos = $("#iznos").val();
            const period = $("#period").val();
            $.post('./server/index.php', {
                akcija: 'kreirajZahtev',
                kredit,
                korisnik,
                iznos,
                period
            }, function (res) {
                const parsed = JSON.parse(res);

                if (!parsed.status) {
                    alert(parsed.error);
                }
                ucitajZahteve();
            })
        })
    })

    function ucitajZahteve() {

        $.getJSON('./server/index.php', { akcija: 'vratiZahteve' }, function (res) {
            if (!res.status) {
                alert(res.error);
                return;
            }
            zahtevi = res.data;
            popuniPodatke();
        })
    }
    function popuniPodatke() {
        const pretraga = $('#pretraga').val();
        const filtrirano = zahtevi.filter(function (zahtev) {
            return zahtev.ime.toLowerCase().includes(pretraga.toLowerCase()) ||
                zahtev.prezime.toLowerCase().includes(pretraga.toLowerCase()) ||
                zahtev.naziv_kredita.toLowerCase().includes(pretraga.toLowerCase()) ||
                zahtev.status.toLowerCase().includes(pretraga.toLowerCase())
        });
        $('#zahtevi').html('');
        for (let zahtev of filtrirano) {
            $('#zahtevi').append(`
                <tr>
                    <td>${zahtev.naziv_kredita}</td>
                    <td>${zahtev.ime + ' ' + zahtev.prezime}</td>
                    <td>${zahtev.iznos} EUR</td>
                    <td>${Number(zahtev.period_otplate).toFixed(0)} meseci</td>
                    <td>${zahtev.stopa}%</td>
                    <td>${(zahtev.ukupno / zahtev.period_otplate).toFixed(2)} EUR</td>
                    <td>${Number(zahtev.ukupno).toFixed(2)} EUR</td>
                    <td>${zahtev.status}</td>
                </tr>
            `)
        }

    }
    function ucitajKredite() {
        $.getJSON('./server/index.php', { akcija: 'vratiKredite' }, function (res) {
            if (!res.status) {
                alert(res.error);
                return;
            }
            for (let kr of res.data) {
                $('#kredit').append(`
                  <option value='${kr.id}'>
                    ${kr.naziv}
                </option>
                `)
            }
        })
    }
    function ucitajKorisnike() {
        $.getJSON("./server/index.php", { akcija: 'vratiKorisnike' }, function (res) {
            if (!res.status) {
                alert(res.error);
                return;
            }
            for (let korisnik of res.data) {
                $('#korisnik').append(`
                    <option value='${korisnik.id}'>${korisnik.ime + ' ' + korisnik.prezime}</option>
                `)
            }
        })
    }
</script>

<?php
    include 'footer.php';
?>