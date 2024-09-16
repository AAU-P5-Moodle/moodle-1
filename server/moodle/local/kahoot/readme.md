 
 


Første step


Brug moodles egen documentation, den er faktisk okay. 

# Hvordan ting fungere

## Overall

Moodles kodestill er meget intern viden deklarativt.()
Mappe og fil strukturen er meget strikt, og virker ikke vis du gør det ude for det gyldige format
Du kan ikke bare neste filer extra ned i mapper osv.

Bemærk foresten at funktioner aldrig bliver kaldt af dig selv.
Det gør moodle automatisk.  

Du kan blive nød til at "purge" din cashe hver gang du skal teste noget som helst! så lidt som at ændre på teksten i en div. (Efter klik tager det typisk 5-10 sek før det tager effect)

http://localhost/admin/purgecaches.php   <--- Er link til at purge din cashe

Støre ændringer fx ændringer i php eller db, kræver at du åbner og lukker serveren

## db

Når man skal lave et table skal du lave en install.php.  Her skal du deklerere dit table som kan blive set i install.php filen, for at lave et nyt table. Det er ikke så komplext


## AMD

Hvis du skal bruge javascript, skal det integreres på en meget bestemt måde.
Personligt kan jeg kun anbefale det til meget custom ting, da moodle selv tilbyder at du kan gøre meget af det i php eller med deres custom funktioner knapper osv.

Men vis du skal, så skal du lave dit js kode på samme format som du ser i scr filen. Her ligger du dine scripts.  Når du ønsker at teste dem skal du kører mit script som ligger i kahoot mappen, som "bygger"/Formatere dit js til det rigtige format.

Naviger til kahoot mappen med cd.  også skriv node script.js

## Lang

God kode stil!

Du har sikkert lagt mærke til funktionen get_string() i alle views. Den bruges til at hente tekststrenge fra lang/en. Det gør din kode fremtidssikret, da du senere kan oprette en lang/da-fil med de samme strenge oversat til dansk, som så automatisk vil blive vist i stedet.

## lib

lib.php bruges i Moodle til at definere generelle funktioner og integrationer for et plugin. Fx jeg bruger den til at extende vores kahoot url.


## script.js

Det er scriptet som du skal bruge til at reformatere din script filer så de kan blive brugt af moodle

## version

version.php bruges i Moodle til at definere pluginets version og afhængigheder. Den angiver versionsnummeret, hvilken Moodle-version pluginet kræver, samt andre vigtige metadata, som Moodle bruger til at styre installation og opdateringer af pluginet. 

Sørg for at holde disse numre rigtigte ellers får du ireterende fejl. Det finder du ud af hvis du laver fejlen :D

Eventuelt bare kopir den version jeg har sat ind.


## Form

Vi bruger moodles form logik
Vi har lagt den i en mappe for sig selv, fordi det er god kodestil
Læg mærke til hvordan vi impotere den i makekahoot.php