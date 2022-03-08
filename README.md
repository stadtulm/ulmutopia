

1) Das komplette Projekt basiert auf Wordpress. In diesem GitHub Repository sind das Plugin (wp-content/plugins/cortex-kulturvermittlung) und das Theme (wp-content/themes/kulturvermittlung) hinterlegt.

2) Folgende Fremdplugins werden zusätzlich benötigt (in Klammer jeweils die aktuelle Version, welche auch gerade für ulmutopia im Livebetrieb eingesetzt wird):

Admin Columns (4.4.5)
Advanced Custom Fields (5.12)
Classic Editor (1.6.2)
Enable Media Replace (3.6.3)
Fix Image Rotation (2.2.2)
Page Builder by SiteOrigin (2.16.4)
SiteOrigin Widgets Bundle (1.30.1)
User Roles and Capabilities (1.2.6)
WP Extended Search (2.0.3)

3) Um die beiden Komponenten betreiben zu können, braucht es zusätzlich in einem frisch installierten Wordpress auch die entsprechenden Seiten (Login, Profil anlegen, Profil anzeigen, ...). Dazu ist eine XML im Repository hinterlegt, mit dem diese Seiten importiert werden können. Das XML beinhaltet nur die Seiten selbst, keine Profile oder Angebote von Ulmutopia.

4) Zum Abschluss der Konfiguration müssen im Plugin noch zwei Dinge konfiguriert werden:

i) In der Datei Cortex_Kulturvermittlung_Config.php müssen die IDs der Seiten im $pageIds Array an nach dem XML Import vergebenen IDs angepasst werden (statt dem Platzhalter -1).
ii) In der Datei Cortex_Kulturvermittlung_Emailer.php muss eine E-Mailadresse angegeben werden, an die die Admin E-Mails gehen (statt dem Platzhalter obody@noone.none).

