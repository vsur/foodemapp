Problem mit der Datenlage gelöst!

Nächster Schritt die Components Choose anpassen, bzw. neue View bauen.


1. ✓ Action für Criterion auswahl aus Awesomeplete bauen. Platzier die Dinger.
  1. ✓ Baue Schalter für Binary
  1. ✓ Ausgabe für Nominal
  1. ✓ Ausgabe für Ordinal
  1. ✓ Setze Nominal-Attr-Auswahl im JS Object chosenSelection
  1. ✓ Setze Ordinal-Attr-Auswahl im JS Object chosenSelection
  1. ✓ Setze Binary-Compnent-Auswahl im JS Object choosen Selection

2. ✓ Query
  1. ✓ Query bauen
  2. ✓ Set Scenario aus Query GUI bauen
    1. ✓ Für Binary
    2. ✓ Für Nominal
    3. ✓ Für Ordinal
    4. ✓ Interation über Params
    5. ✓ Rating wird dznamisch gesetzt
  3. ✓ Aus Query dann Search Matches bauen
    1. ✓ Reine Debugausgabe
    2. ✓ Liste
      1. ✓ Mobile
      2. ✓ Dekstop
    3. ✓ Filter-Ansicht als zurück Button implementieren
    4. Filter/Wheel aka Komponenten Rad bauen
        *   ✓ Erst mal die Hierchie aufbauen.
        *   ✓ In den Ringen dann Unter-Ringe von Skalen: Binär, Nominal, Ordinal
        *   ✓ Darin dann die Komponenten
        *   ✓ Also Ranked, dann übrige, dann einzelne Gewichtungsgruppen like in <https://observablehq.com/@d3/zoomable-sunburst>
            * ✓ Problem, die Observablke Sachen sind notbeooks und nicht pure JS.
            * ✓ Am besten mal schauen ob die V5 von D3 tut was sie bisher soll.
            * ✓ Und schauen wie man an non Observable Code von Zoomable Sunburst ran kommt.
            * ✓ Hilfereich evtl andere Sunburst Tuts
        * Dynmaisches Zeichnen einbauen
        * Zoom später einbauen
4. Chroddiagram
    1. ✓ Erste Version von Stephan einbauen
    2. ✓ Überareitung
    3. ✓ Erneuter Einbau
    4. Fine Tuning
3. Karte
    1. Dekstop
        1. ✓ Binary True werden falsch gesetzt
        2. Kartenzusammenfassung muss realisiert werden
        3. Umschalter zw. gewählt übrigen usw. 
    1. Mobile
        1. Test
5. Weitere GUI-Elemente
6. Zusammenspiel der GUIS, Selektion usw.
7. Dann noch mal hübsch machen


*** Notes ***

Switch einfach aus Checkbox siehe https://www.w3schools.com/howto/howto_css_switch.asp

Wo kam das erste undefined her? Weil du trottel eine Variable in JS instantierst aber nicht deklarierst und dann eine Stringverkettung machst, geht nicht! Depp!

Nehme nie #/. mit in die Class- bzw Id-Namen mit auf, jQuery kriegt das nicht getrennt, wie auch! Dummer Veit.

*** Daten Fehlen ***
** NC BYOB/Corkage **
Es gitb keine YPOIS für NC BYOB/Corkage?! Es muss noch mal geklärt werden warum, im Ursprungsdatensatz sind 1315 Stück voranden. Die eigentlich auch passen müssten
** Ages Allowed **
Hier gibts nur ein 1?! mit 21plus die 19plus zeigen evtl. Night Clubs (no Match auf Essensrelation)
allages = 21, 0 = ypois
18plus = 50 , 0 = ypois
19plus = 5, 0 = ypois
21plus = 177, 1 = ypois
*** Music/Fehl ***
Karaoke und Live (vermutlich wg. fehlender Essensrelation)
*** Good For fehlt auch oft (22080 währen in Yelp) ***
*** Diatry Restrictions gibt es nur 18 für Vegan, 156 sind nur in Yelp, aber ich weiß noch nicht wieviele davon nicht vegan ***
Es sind eigentlich 52 vegiterian in YELP TODO Check why not YPOIS ({'attributes.Dietary Restrictions': {$exists: true},'attributes.Dietary Restrictions.vegetarian': true})
*** Ambience ***
Hier gibts nur Casual, Hispster, Trendy und romantic = 17 Gesamt. Obwohl 21447 in Yelp Ambience haben, hier noch mal mit Query Builder checken, wie viele auf OR subattr = true stehen.

Bei den Ordinal Componenten und Attributen gibt es überall was
