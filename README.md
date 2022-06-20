# DTI-tudengitööde-portaal

![Screenshot (4)](https://user-images.githubusercontent.com/90316656/174557210-f561a878-9acb-463f-b9ef-5e7b9e45dcfa.png)

![Screenshot (5)](https://user-images.githubusercontent.com/90316656/174557254-10987080-5901-410f-bad2-590d7adf6b88.png)

![Screenshot (6)](https://user-images.githubusercontent.com/90316656/174557305-e461336c-8891-4bdb-bc0a-bd912154b106.png)

![Screenshot (7)](https://user-images.githubusercontent.com/90316656/174557323-c3cd156f-12a4-46ed-a6f2-121d53d7950a.png)

![Screenshot (8)](https://user-images.githubusercontent.com/90316656/174557337-bd4ed5a7-182a-4bd6-92a5-f4334c65be6a.png)

# Eesmärk ja lühikirjeldus

Üleüldine eesmärk on tudengitele pakkuda lihtne ja tänapäevane lehekülg, kus nad saavad oma projekte postitada ning portfooliot arendada. Meie platvorm on aktuaalne tudengitele, kes on just lõpetamas. See annab neile võimaluse presenteerida oma oskusi ühest kohast, kui nad hakkavad tööd otsima pärast ülikooli. Samuti on meie platvorm kasulik ka õpetajatele. Enam ei ole nii, et peab kusagilt kaustast otsima kellegi tehtud tööd, sest meie lehel on kõik leitav ühest kohast. 

Töö on tehtud Tallinna Ülikooli Digitehnoloogiate instituudi informaatika eriala suvepraktika raames.

# Kasutatud tehnoloogiad

HTML5

CSS3

PHP 7.4.20

MariaDB 10.2.25

JavaScript 1.7

# Meeskond

Lika Berisvili

Henry Naptal

Mari Hõbemets 

Taavet Tenso

Morten-Paul Mühlberg

# Kasutusjuhend

1. Paigaldage arvutisse uusim versioon XAMPP’ist.
2. Laadige alla meie projekti repositoorium Githubist.
3. Avage XAMPP ning vajutage nupule “Explorer”, seejärel avaneb teile XAMPP’i kaust.
4. Avage XAMPP’i kaustas olev “htdocs” kaust.
5. Tõstke alla laetud projekti repositooriumi seest kaust “dti_portaal” kausta “htdocs”.
6. Avage htdocsis asuv “dti_portaal” kaust ning seejärel “database” kaust.
7. Avage “config.php” fail mõne teksti redigeerimise programmiga(Nt: Notepad, Visual Studio Code) ning muutke failis olevad parameetrid selliseks nagu nad on pildil:
![Pildike](https://user-images.githubusercontent.com/90316656/174602648-5a1789ec-99ad-447f-a6cb-d6cd2262aa1c.PNG)

8. Salvestage “config.php” fail ning sulgege see.
9. Suunduge XAMPP’i ja käivitage Apache ning MySQL moodulid nupust “Start”.
10. Avage endale meelepärases veebibrauseris leht “localhost/phpmyadmin” või vajutage XAMPP’is nupule “Admin”, mis on MySQL’ga samal joonel. 
11. Avaneb andmebaasi leht, kuhu peate importima meie projekti andmebaasi tabelid.
12. Esmalt valige vasakult menüüst nupp “New” ja määrake andmebaasi nimeks “if21_dti_portaal” ning seejärel vajutage nuppu “Create”.
13. Andmebaasi importimiseks peate klikkima vasakul menüüs olevale “if21_dti_portaal” nupule ja suunduma andmebaasis üleval riba peal olevale “import” lehele ning valima meie projekti kaustast(C:\xampp\htdocs\dti_portaal) faili “if21_dti_portaal.sql” ja seejärel vajutama lehe allpool olevat nuppu “import”.
14. Kui kõik sujust hästi, siis nüüd on meie portaal kasutamiseks valmis. Selleks suunduge lehele: “localhost/dti_portaal/login.php”

# Lingid

## Lehekülje aadress 

https://greeny.cs.tlu.ee/~hennap/dti_portaal/avaleht.php

## Dokumentatsioon

https://docs.google.com/document/d/1jLT_aHiDl-26IkF34wLka9-660ksi1O-Uo5TUgfwQ7I/edit?fbclid=IwAR1pgMr_ZOhucqzgPNz746Op1adeBAEXN4qPj5f2KjkDMgEhtz5XRoMDKcM

## Blogi

http://suvepraktika.cs.tlu.ee/2022/ryhm01

