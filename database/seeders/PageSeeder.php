<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tos = <<<EOT
<h4 class="mb-4">TERMENI ȘI CONDIȚII – LOTUSRETREAT.RO</h4>

<p>Acest document stabilește termenii și condițiile de utilizare ale website-ului www.lotusretreat.ro, precum și condițiile aplicabile comenzilor plasate prin intermediul acestui website.</p>

<p>Prin accesarea site-ului și/sau plasarea unei comenzi, Clientul confirmă că a citit, înțeles și acceptat integral prezentul document.</p>

<hr class="my-4">

<h5 class="fw-bold">1. Informații despre comerciant</h5>
<p>Website-ul lotusretreat.ro este administrat de:</p>
<p>
    <strong>Asociația Lotus Retreat</strong><br>
    CUI: 50175955<br>
    Cont bancar (IBAN): <br>
    E-mail: asociatialotusretreat@gmail.com<br>
    Telefon: 0753.645.442
</p>
<p>În continuare denumit „Vânzătorul” sau „Lotus Retreat”.</p>

<hr class="my-4">

<h5 class="fw-bold">2. Definiții</h5>
<ul>
    <li><strong>Client / Cumpărător</strong> – orice persoană fizică sau juridică ce plasează o comandă.</li>
    <li><strong>Produse</strong> – bunurile comercializate prin lotusretreat.ro (handmade, personalizate, realizate pe comandă).</li>
    <li><strong>Comandă</strong> – solicitarea transmisă de Client către Vânzător pentru achiziția unuia sau mai multor produse.</li>
    <li><strong>Contract la distanță</strong> – contractul încheiat între Vânzător și Client fără prezența fizică simultană a celor două părți.</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">3. Descrierea produselor. Produse handmade și caracter unic</h5>
<p>Produsele comercializate pe lotusretreat.ro sunt realizate manual (handmade), iar majoritatea sunt realizate pe comandă, fiind unice și adaptate fiecărui Client.</p>
<p>Clientul înțelege și acceptă că produsele handmade pot prezenta:</p>
<ul>
    <li>mici imperfecțiuni estetice;</li>
    <li>variații de culoare, textură, formă și dimensiune;</li>
    <li>diferențe între produsul final și fotografiile de prezentare.</li>
</ul>
<p>Fotografiile afișate pe site au caracter informativ/orientativ și pot exista diferențe în funcție de lumina ambientală sau setările ecranului. De asemenea, toate produsele prezentate pe site sunt produse deja vândute iar clientul nu poate primi un produs identic cu cel afișat.</p>
<p>Aceste particularități sunt normale pentru produsele realizate manual și nu reprezintă defecte.</p>

<hr class="my-4">

<h5 class="fw-bold">4. Produse realizate pe comandă / personalizate:</h5>
<p>Toate produsele Lotus Retreat sunt realizate pe comandă, iar personalizarea poate include, fără a se limita la:</p>
<ul>
    <li>dimensiuni;</li>
    <li>selecție de cristale și combinații speciale;</li>
    <li>structură și configurație;</li>
    <li>gravură sau simboluri;</li>
    <li>adaptare în funcție de spațiu, intenție sau cerințele Clientului.</li>
</ul>
<p>Clientul acceptă faptul că produsele sunt realizate în mod personalizat și pot exista diferențe semnificative de culoare și materiale, inclusiv cristale diferite față de fotografii, deoarece produsul este 100% realizat în funcție de comandă, disponibilitatea materialelor și compatibilitatea configurației.</p>

<hr class="my-4">

<h5 class="fw-bold">5. Termen de execuție și livrare:</h5>
<p>Produsele personalizate se realizează în funcție de complexitate, disponibilitatea materialelor și volumul de lucru.</p>
<p>Termenul estimativ de execuție pentru produsele realizate pe comandă este între: <strong>5 zile și 3 luni</strong>.</p>
<p>Acest termen este orientativ și poate varia în funcție de:</p>
<ul>
    <li>complexitatea produsului;</li>
    <li>materialele necesare;</li>
    <li>perioade aglomerate;</li>
    <li>întârzieri ale furnizorilor sau alte situații neprevăzute.</li>
</ul>
<p>Lotus Retreat va comunica Clientului estimarea termenului înainte sau după confirmarea comenzii.</p>

<hr class="my-4">

<h5 class="fw-bold">6. Plasarea comenzii</h5>
<p>Comanda poate fi plasată prin:</p>
<ul>
    <li>website;</li>
    <li>e-mail;</li>
    <li>telefon;</li>
    <li>mesaje pe canalele oficiale Lotus Retreat.</li>
</ul>
<p>O comandă devine fermă doar după confirmarea acesteia de către Vânzător.</p>
<p>Vânzătorul își rezervă dreptul de a refuza o comandă în următoarele situații:</p>
<ul>
    <li>date incomplete sau incorecte;</li>
    <li>imposibilitatea tehnică de realizare;</li>
    <li>comportament abuziv sau neadecvat al Clientului;</li>
    <li>suspiciuni rezonabile de fraudă.</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">7. Prețuri</h5>
<p>Toate prețurile sunt exprimate în RON.</p>
<p>Vânzătorul își rezervă dreptul de a modifica prețurile afișate, însă comenzile confirmate rămân la prețul acceptat de Client în momentul plasării comenzii.</p>

<hr class="my-4">

<h5 class="fw-bold">8. Modalități de plată</h5>
<p>Plata produselor se poate face prin:</p>
<ul>
    <li>transfer bancar;</li>
    <li>ramburs (dacă este disponibil pentru produsul respectiv);</li>
    <li>alte metode afișate pe site.</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">9. Avans și condiții speciale pentru produsele pe comandă</h5>
<p>Pentru produsele realizate pe comandă, Vânzătorul poate solicita un avans (parțial sau integral), în funcție de tipul produsului și complexitatea acestuia.</p>
<p>Comanda intră în execuție doar după confirmarea plății avansului.</p>
<p><strong>9.1 Avans nerambursabil</strong></p>
<p>Clientul înțelege și acceptă că avansul este nerambursabil, deoarece presupune:</p>
<ul>
    <li>rezervarea materialelor;</li>
    <li>achiziția componentelor;</li>
    <li>timp de lucru;</li>
    <li>costuri de producție și personalizare.</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">10. Anularea comenzii</h5>
<p><strong>10.1. Anulare înainte de execuție</strong></p>
<p>În cazul anulării comenzii de către Client după achitarea avansului, avansul nu se returnează.</p>
<p><strong>10.2. Anulare după începerea execuției / produs finalizat</strong></p>
<p>În cazul în care produsul a intrat în execuție sau este finalizat, Clientul înțelege și acceptă că:</p>
<ul>
    <li>avansul nu este rambursabil;</li>
    <li>Clientul este obligat să achite integral produsul, chiar dacă se răzgândește;</li>
    <li>refuzul coletului sau neridicarea coletului nu anulează obligația de plată.</li>
</ul>
<p>Produsele realizate la comandă sunt produse personalizate și nu pot fi revândute ca produse standard.</p>

<hr class="my-4">

<h5 class="fw-bold">11. Dreptul de retragere (retur)</h5>
<p>Conform OUG 34/2014, dreptul de retragere de 14 zile nu se aplică produselor realizate după specificațiile Clientului sau personalizate.</p>
<p>Prin natura activității Lotus Retreat, produsele sunt realizate pe comandă, conform cerințelor Clientului, incluzând selecția de cristale și materiale speciale.</p>
<p>Prin urmare:</p>
<ul>
    <li>nu se acceptă retur din motive de răzgândire;</li>
    <li>nu se rambursează avansul;</li>
    <li>nu se acceptă retur pentru motive precum: „nu îmi place”, „nu arată ca în poze”, „nu se potrivește cu decorul”, „m-am răzgândit” etc.</li>
</ul>
<p>Această excludere este aplicabilă conform art. 16 lit. c din OUG 34/2014.</p>

<hr class="my-4">

<h5 class="fw-bold">12. Excepție – produse standard (dacă există)</h5>
<p>În situația rară în care lotusretreat.ro comercializează produse care NU sunt realizate pe comandă și NU sunt personalizate (produse standard, existente în stoc), Clientul poate beneficia de dreptul legal de retragere în termen de 14 zile calendaristice, cu respectarea următoarelor condiții:</p>
<ul>
    <li>produsul este returnat în aceeași stare în care a fost primit;</li>
    <li>produsul nu prezintă urme de utilizare;</li>
    <li>produsul este ambalat corespunzător;</li>
    <li>cheltuielile de retur sunt suportate de Client.</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">13. Produse deteriorate în timpul transportului (curier)</h5>
<p>Dacă produsul ajunge deteriorat în timpul transportului, Clientul trebuie să anunțe Lotus Retreat în maximum 48 ore de la primire, prin e-mail sau mesaj, însoțit de fotografii/video clare.</p>
<p>În funcție de situație, Lotus Retreat poate oferi:</p>
<ul>
    <li>repararea produsului;</li>
    <li>înlocuirea produsului (dacă este posibil).</li>
</ul>
<p>Clientul are obligația de a păstra ambalajul coletului și de a oferi dovezi relevante.</p>

<hr class="my-4">

<h5 class="fw-bold">14. Produse electronice (ex. generatoare de frecvență)</h5>
<p>Pentru produsele electronice (ex. generatoare de frecvență), Clientul este rugat să verifice funcționarea produsului imediat după primire.</p>
<p>Orice problemă de funcționare trebuie semnalată în termen de 48 h de la primirea coletului.</p>
<p>Dacă se constată un defect tehnic care nu ține de utilizarea Clientului, Lotus Retreat va oferi:</p>
<ul>
    <li>reparație,</li>
    <li>înlocuire componente,</li>
    <li>înlocuire produs (dacă este necesar).</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">15. Excluderea garanției în cazul deteriorării provocate de Client</h5>
<p>Lotus Retreat nu este responsabil pentru defectele apărute din cauza utilizării necorespunzătoare a produselor.</p>
<p>Nu se acordă reparații gratuite și nu se acceptă reclamații în situațiile în care produsul a fost deteriorat din vina Clientului, inclusiv dar fără a se limita la:</p>
<ul>
    <li>lovire sau scăpare pe jos;</li>
    <li>expunere la apă, umezeală sau lichide;</li>
    <li>expunere la foc sau temperaturi extreme;</li>
    <li>conectare la surse de curent necorespunzătoare;</li>
    <li>intervenții neautorizate;</li>
    <li>utilizare contrară instrucțiunilor primite.</li>
</ul>
<p>În aceste cazuri, Vânzătorul poate oferi reparație contra cost, dacă produsul permite.</p>

<hr class="my-4">

<h5 class="fw-bold">16. Responsabilitatea Clientului pentru măsurători și specificații</h5>
<p>Pentru produsele care necesită dimensiuni exacte (ex. piramide de meditație sau alte structuri realizate pentru un spațiu anume), Clientul este responsabil să furnizeze măsurători corecte.</p>
<p>Dacă produsul a fost realizat conform informațiilor oferite de Client, confirmate prin mesaj/apel telefonic, iar ulterior Clientul constată că dimensiunea nu se potrivește, aceasta nu constituie motiv de retur sau rambursare.</p>

<hr class="my-4">

<h5 class="fw-bold">17. Livrare</h5>
<p>Livrarea se face prin curier, la adresa indicată de Client.</p>
<p>Costul livrării este comunicat înainte de finalizarea comenzii.</p>
<p>Lotus Retreat nu este responsabil pentru întârzierile cauzate de firma de curierat.</p>

<hr class="my-4">

<h5 class="fw-bold">18. Refuz colet / neridicare colet</h5>
<p>În cazul în care Clientul refuză coletul la livrare sau nu îl ridică din punctul de livrare, comanda este considerată finalizată.</p>
<p>Clientul acceptă faptul că:</p>
<ul>
    <li>avansul nu se returnează;</li>
    <li>dacă produsul a fost finalizat, acesta trebuie achitat integral;</li>
    <li>Clientul poate fi obligat să suporte costurile de transport tur-retur.</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">19. Facturare</h5>
<p>Vânzătorul emite factură fiscală conform legislației în vigoare, pe baza datelor furnizate de Client.</p>
<p>Clientul este responsabil pentru corectitudinea datelor de facturare transmise.</p>

<hr class="my-4">

<h5 class="fw-bold">20. Proprietate intelectuală</h5>
<p>Conținutul website-ului lotusretreat.ro (texte, imagini, logo, descrieri, materiale audio/video, design) este proprietatea Lotus Retreat și nu poate fi copiat, distribuit sau utilizat fără acord scris.</p>

<hr class="my-4">

<h5 class="fw-bold">21. Limitarea răspunderii</h5>
<p>Lotus Retreat nu poate fi tras la răspundere pentru:</p>
<ul>
    <li>diferențe estetice specifice produselor handmade;</li>
    <li>variații de cristale și materiale în cadrul personalizării;</li>
    <li>măsurători greșite furnizate de Client;</li>
    <li>deteriorarea produselor cauzată de utilizare necorespunzătoare;</li>
    <li>întârzieri cauzate de curier;</li>
    <li>imposibilitatea livrării din cauza datelor greșite furnizate de Client.</li>
</ul>

<hr class="my-4">

<h5 class="fw-bold">22. Protecția datelor personale (GDPR)</h5>
<p>Datele personale furnizate de Client sunt utilizate exclusiv pentru:</p>
<ul>
    <li>procesarea comenzilor;</li>
    <li>comunicare;</li>
    <li>livrare;</li>
    <li>facturare;</li>
    <li>campanii promoționale.</li>
</ul>
<p>Lotus Retreat respectă prevederile Regulamentului UE 679/2016 (GDPR).</p>
<p>Detalii complete sunt disponibile în pagina separată: Politica de Confidențialitate.</p>

<hr class="my-4">

<h5 class="fw-bold">23. Forța majoră</h5>
<p>Forța majoră exonerează părțile de răspundere în cazul imposibilității executării obligațiilor contractuale, conform legislației în vigoare.</p>

<hr class="my-4">

<h5 class="fw-bold">24. Litigii</h5>
<p>Orice neînțelegere va fi soluționată pe cale amiabilă.</p>
<p>În cazul în care nu se poate ajunge la o soluție amiabilă, litigiile vor fi soluționate de instanțele competente din România.</p>

<hr class="my-4">

<h5 class="fw-bold">25. Contact</h5>
<p>Pentru suport, întrebări sau reclamații:</p>
<p>
    E-mail: asociatialotusretreat@gmail.com<br>
    Telefon: 0753.645.442<br>
    Program: Luni - Vineri: 9:00 - 15:00
</p>

<hr class="my-4">

<h5 class="fw-bold text-uppercase text-center">Confirmarea Clientului</h5>
<p>Prin plasarea unei comenzi pe lotusretreat.ro, Clientul confirmă că a luat la cunoștință și acceptă faptul că:</p>
<ul>
    <li>produsele sunt handmade și pot avea variații estetice;</li>
    <li>produsele sunt realizate pe comandă și sunt personalizate inclusiv prin materiale și cristale;</li>
    <li>avansul achitat este nerambursabil;</li>
    <li>produsele personalizate nu se returnează;</li>
    <li>termenul de execuție poate fi între 5 zile și 3 luni.</li>
</ul>
EOT;

        // 1. Seed Termeni si Conditii
        Page::firstOrCreate(
            ['slug' => 'termeni-si-conditii'],
            [
                'title' => 'Termeni și Condiții (TOS)',
                'is_system' => true,
                'is_active' => true,
                'content' => $tos
            ]
        );

        // 2. Seed Politica de Retur
        Page::firstOrCreate(
            ['slug' => 'politica-de-retur'],
            [
                'title' => 'Politică de Retur',
                'is_system' => true,
                'is_active' => true,
                'content' => '<p>Conținutul pentru politica de retur va fi adăugat aici...</p>'
            ]
        );
    }
}
