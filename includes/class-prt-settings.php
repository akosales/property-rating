<?php

// Required
require_once PRT_DIR_HOME . 'includes/class-wposa.php';

class Prt_Settings {

    private $wposa;

    public function __construct($run) {
        if($run) $this->runSettings();
    }

    public function runSettings() {
        $this->wposa = new WP_OSA();
        $this->section_general();
        $this->section_style();
        $this->section_email();
    }

    public function section_general() {
        //Section
        $this->wposa->add_section(
			array(
				'id'    => 'prt_settings_general',
				'title' => __( 'Allgemein', 'prt' ),
			)
        );
		
		$this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'company-name',
				'type'    => 'text',
				'name'    => __( 'Firmenname', 'prt' ),
				'desc'    => '',
				'placeholder' => 'Firmenname',
			)
        );

        //Field: GOOGLE API KEY
        $this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'google-api-key',
				'type'    => 'text',
				'name'    => __( 'Google Maps API', 'prt' ),
				'desc'    => __( 'Geben Sie hier bitte den Schlüssel (Key) für die Google API ein.', 'prt' ),
				'placeholder' => '',
			)
        );
        //Field: IS24 Consumer Key
        $this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'is24-key',
				'type'    => 'text',
				'name'    => __( 'ImmobilienScout 24 (Key)', 'prt' ),
				'desc'    => __( 'Geben Sie hier bitte den Schlüssel (Key) für die ImmobilienScout24 API ein.', 'prt' ),
				'placeholder' => '',
			)
        );
        //Field: IS24 Consumer Secret
        $this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'is24-secret',
				'type'    => 'text',
				'name'    => __( 'ImmobilienScout 24 (Secret)', 'prt' ),
				'desc'    => __( 'Geben Sie hier bitte den Geheimcode (Secret) für die ImmobilienScout24 API ein.', 'prt' ),
				'placeholder' => '',
			)
		);
        //Field: Advantages
        $this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'advantages',
				'type'    => 'wysiwyg',
				'name'    => __( 'Vorteile', 'prt' ),
				'desc'    => __( 'Hier können Sie die Vorteile eintragen. HTML ist erlaubt.<br>Benutzen Sie <b>&#x3C;ul class=&#x22;haken&#x22;&#x3E;</b> um die Punkte durch Haken zu ersetzten.', 'prt' ),
				'default' => '<ul class="haken"><li>Vorteil 1</li><li>Vorteil 2</li></ul>',
			)
		);
		//Field: Privacy Policy (Datenschutz)
        $this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'privacy-policy',
				'type'    => 'wysiwyg',
				'name'    => __( 'Datenschutz', 'prt' ),
				'desc'    => __( 'Schreiben Sie hier Ihre Datenschutzerklärung für die der Kundendaten. HTML ist erlaubt.', 'prt' ),
				'default' => '<h1>Datenschutzerklärung</h1>
							<h2>Datenschutz</h2>
							Die Betreiber dieser Seiten nehmen
							den Schutz Ihrer persönlichen Daten sehr ernst. Wir behandeln Ihre personenbezogenen Daten
							vertraulich und entsprechend der gesetzlichen Datenschutzvorschriften sowie dieser
							Datenschutzerklärung.

							Die Nutzung unserer Webseite ist in der Regel ohne Angabe
							personenbezogener Daten möglich. Soweit auf unseren Seiten personenbezogene Daten
							(beispielsweise Name, Anschrift oder E-Mail-Adressen) erhoben werden, erfolgt dies, soweit
							möglich, stets auf freiwilliger Basis. Diese Daten werden ohne Ihre ausdrückliche Zustimmung
							nicht an Dritte weitergegeben.

							Wir weisen darauf hin, dass die Datenübertragung im Internet
							(z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser
							Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.

							&nbsp;
							<h2>Cookies</h2>
							Die Internetseiten verwenden teilweise so genannte Cookies. Cookies richten auf Ihrem
							Rechner keinen Schaden an und enthalten keine Viren. Cookies dienen dazu, unser Angebot
							nutzerfreundlicher, effektiver und sicherer zu machen. Cookies sind kleine Textdateien, die auf Ihrem
							Rechner abgelegt werden und die Ihr Browser speichert.

							Die meisten der von uns verwendeten
							Cookies sind so genannte „Session-Cookies“. Sie werden nach Ende Ihres Besuchs automatisch
							gelöscht. Andere Cookies bleiben auf Ihrem Endgerät gespeichert, bis Sie diese löschen.
							Diese Cookies ermöglichen es uns, Ihren Browser beim nächsten Besuch
							wiederzuerkennen.

							Sie können Ihren Browser so einstellen, dass Sie über das Setzen
							von Cookies informiert werden und Cookies nur im Einzelfall erlauben, die Annahme von Cookies für
							bestimmte Fälle oder generell ausschließen sowie das automatische Löschen der
							Cookies beim Schließen des Browser aktivieren. Bei der Deaktivierung von Cookies kann die
							Funktionalität dieser Website eingeschränkt sein.

							&nbsp;
							<h2>Server-Log-
							Files</h2>
							Der Provider der Seiten erhebt und speichert automatisch Informationen in so genannten
							Server-Log Files, die Ihr Browser automatisch an uns übermittelt. Dies sind:
							<ul>
								<li>Browsertyp und Browserversion</li>
								<li>verwendetes Betriebssystem</li>
								<li>Referrer URL</li>
								<li>Hostname des zugreifenden Rechners</li>
								<li>Uhrzeit der Serveranfrage</li>
							</ul>
							Diese Daten sind
							nicht bestimmten Personen zuordenbar. Eine Zusammenführung dieser Daten mit anderen
							Datenquellen wird nicht vorgenommen. Wir behalten uns vor, diese Daten nachträglich zu
							prüfen, wenn uns konkrete Anhaltspunkte für eine rechtswidrige Nutzung bekannt werden.

							&nbsp;
							<h2>Kontaktformular</h2>
							Wenn Sie uns per Kontaktformular Anfragen zukommen
							lassen, werden Ihre Angaben aus dem Anfrageformular inklusive der von Ihnen dort angegebenen
							Kontaktdaten zwecks Bearbeitung der Anfrage und für den Fall von Anschlussfragen bei uns
							gespeichert. Diese Daten geben wir nicht ohne Ihre Einwilligung weiter.

							&nbsp;
							<h2>Facebook-Plugins (Like-Button)</h2>
							Auf unseren Seiten sind Plugins des sozialen Netzwerks
							Facebook, Anbieter Facebook Inc., 1 Hacker Way, Menlo Park, California 94025, USA, integriert. Die
							Facebook-Plugins erkennen Sie an dem Facebook-Logo oder dem "Like-Button" ("Gefällt mir") auf
							unserer Seite. Eine Übersicht über die Facebook-Plugins finden Sie hier: <a href="https://developers.facebook.com/docs/plugins/">https://developers.facebook.com/docs/plugins/</a>
							.

							Wenn Sie unsere Seiten besuchen, wird über das Plugin eine direkte Verbindung zwischen
							Ihrem Browser und dem Facebook-Server hergestellt. Facebook erhält dadurch die Information,
							dass Sie mit Ihrer IP-Adresse unsere Seite besucht haben. Wenn Sie den Facebook "Like-Button"
							anklicken während Sie in Ihrem Facebook-Account eingeloggt sind, können Sie die Inhalte
							unserer Seiten auf Ihrem Facebook-Profil verlinken. Dadurch kann Facebook den Besuch unserer Seiten
							Ihrem Benutzerkonto zuordnen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis
							vom Inhalt der übermittelten Daten sowie deren Nutzung durch Facebook erhalten. Weitere
							Informationen hierzu finden Sie in der Datenschutzerklärung von Facebook unter <a href="https://dede. facebook.com/policy.php">https://de-de.facebook.com/policy.php</a>.

							Wenn Sie nicht
							wünschen, dass Facebook den Besuch unserer Seiten Ihrem Facebook-Nutzerkonto zuordnen
							kann, loggen Sie sich bitte aus Ihrem Facebook-Benutzerkonto aus.

							&nbsp;
							<h2>Twitter</h2>
							Auf unseren Seiten sind Funktionen des Dienstes Twitter eingebunden. Diese Funktionen werden
							angeboten durch die Twitter Inc., 1355 Market Street, Suite 900, San Francisco, CA 94103, USA. Durch
							das Benutzen von Twitter und der Funktion "Re-Tweet" werden die von Ihnen besuchten Webseiten mit
							Ihrem Twitter-Account verknüpft und anderen Nutzern bekannt gegeben. Dabei werden auch Daten
							an Twitter übertragen. Wir weisen darauf hin, dass wir als Anbieter der Seiten keine Kenntnis vom
							Inhalt der übermittelten Daten sowie deren Nutzung durch Twitter erhalten. Weitere Informationen
							hierzu finden Sie in der Datenschutzerklärung von Twitter unter <a href="https://twitter.com/privacy">
							https://twitter.com/privacy</a>.

							Ihre Datenschutzeinstellungen bei Twitter können Sie in den
							Konto-Einstellungen unter: <a href="https://twitter.com/account/settings">
							https://twitter.com/account/settings</a> ändern.

							&nbsp;
							<h2>Google+</h2>
							Unsere
							Seiten nutzen Funktionen von Google+. Anbieter ist die Google Inc., 1600 Amphitheatre Parkway
							Mountain View, CA 94043, USA.

							Erfassung und Weitergabe von Informationen: Mithilfe der
							Google+-Schaltfläche können Sie Informationen weltweit veröffentlichen. Über die
							Google+-Schaltfläche erhalten Sie und andere Nutzer personalisierte Inhalte von Google und
							unseren Partnern. Google speichert sowohl die Information, dass Sie für einen Inhalt +1 gegeben
							haben, als auch Informationen über die Seite, die Sie beim Klicken auf +1 angesehen haben. Ihre
							+1 können als Hinweise zusammen mit Ihrem Profilnamen und Ihrem Foto in Google-Diensten, wie
							etwa in Suchergebnissen oder in Ihrem Google-Profil, oder an anderen Stellen auf Websites und
							Anzeigen im Internet eingeblendet werden.

							Google zeichnet Informationen über Ihre +1-
							Aktivitäten auf, um die Google-Dienste für Sie und andere zu verbessern. Um die Google+-
							Schaltfläche verwenden zu können, benötigen Sie ein weltweit sichtbares,
							öffentliches Google-Profil, das zumindest den für das Profil gewählten Namen enthalten
							muss. Dieser Name wird in allen Google-Diensten verwendet. In manchen Fällen kann dieser Name
							auch einen anderen Namen ersetzen, den Sie beim Teilen von Inhalten über Ihr Google-Konto
							verwendet haben. Die Identität Ihres Google-Profils kann Nutzern angezeigt werden, die Ihre E-Mail-
							Adresse kennen oder über andere identifizierende Informationen von Ihnen verfügen.

							Verwendung der erfassten Informationen: Neben den oben erläuterten Verwendungszwecken
							werden die von Ihnen bereitgestellten Informationen gemäß den geltenden Google-
							Datenschutzbestimmungen genutzt. Google veröffentlicht möglicherweise zusammengefasste
							Statistiken über die +1-Aktivitäten der Nutzer bzw. gibt diese an Nutzer und Partner weiter, wie
							etwa Publisher, Inserenten oder verbundene Websites.

							&nbsp;
							<h2>XING</h2>
							Unsere
							Webseite nutzt Funktionen des Netzwerks XING. Anbieter ist die XING AG, Dammtorstraße 29-32,
							20354 Hamburg, Deutschland. Bei jedem Abruf einer unserer Seiten, die Funktionen von XING
							enthält, wird eine Verbindung zu Servern von XING hergestellt. Eine Speicherung von
							personenbezogenen Daten erfolgt dabei nach unserer Kenntnis nicht. Insbesondere werden keine IPAdressen
							gespeichert oder das Nutzungsverhalten ausgewertet.

							Weitere Information zum
							Datenschutz und dem XING Share-Button finden Sie in der Datenschutzerklärung von XING unter:
							<a href="https://www.xing.com/app/share?op=data_protection">
							https://www.xing.com/app/share?op=data_protection</a>

							&nbsp;
							<h2>Recht auf Auskunft,
							Löschung, Sperrung</h2>
							Sie haben jederzeit das Recht auf unentgeltliche Auskunft über
							Ihre gespeicherten personenbezogenen Daten, deren Herkunft und Empfänger und den Zweck der
							Datenverarbeitung sowie ein Recht auf Berichtigung, Sperrung oder Löschung dieser Daten. Hierzu
							sowie zu weiteren Fragen zum Thema personenbezogene Daten können Sie sich jederzeit unter der
							im Impressum angegebenen Adresse an uns wenden.

							&nbsp;
							<h2>Widerspruch Werbe-
							Mails</h2>
							Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten
							zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien
							wird hiermit widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte
							im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-E-Mails, vor.

							&nbsp;

							Quelle: <a href="https://www.e-recht24.de/muster-datenschutzerklaerung.html">
							https://www.e-recht24.de/muster-datenschutzerklaerung.html</a>',
			)
		);
		//Field: Objektnummer
        $this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'objectnumber',
				'type'    => 'text',
				'name'    => __( 'Objektnummer', 'prt' ),
				'desc'    => __( 'Diese Nummer wird später beim OpenImmo Export benötigt', 'prt' ),
				'placeholder' => 'Objektnummer'
			)
		);
		//Field: Shortcode
        $this->wposa->add_field(
			'prt_settings_general',
			array(
				'id'      => 'shortcode',
				'type'    => 'text',
				'name'    => __( 'Shortcode', 'prt' ),
				'desc'    => __( 'Hier können Sie den Shortcode austauschen. Bitte geben Sie die eckigen Klammern mit ein.<br>Beispiel: <b>[BEWERTUNG]</b> oder <b>[EIN_LANGER_NAME_ODER_AUCH_NICHT]</b>', 'prt' ),
				'default' => '[PRT_INCLUDE]'
			)
		);
    }

    public function section_style() {
        //Section
        $this->wposa->add_section(
			array(
				'id'    => 'prt_settings_style',
				'title' => __( 'Gestaltung', 'prt' ),
			)
        );
        
        //Field: Primary Color
        $this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'primary_color',
				'type'    => 'color',
				'name'    => __( 'Primäre Farbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die primäre Farbe ändern.', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: Secondary Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'secondary_color',
				'type'    => 'color',
				'name'    => __( 'Sekundäre Farbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die sekundäre Farbe ändern.', 'prt' ),
				'default' => '#ffffff'
			)
		);
		//Field: Progress Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'progress_color',
				'type'    => 'color',
				'name'    => __( 'Forschrittsbalken: Farbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die Farbe des Forschrittsbalken abändern.', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: Progress Text Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'progress_text_color',
				'type'    => 'color',
				'name'    => __( 'Forschrittsbalken: Schriftfarbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die Schriftfarbe des Forschrittsbalken abändern.', 'prt' ),
				'default' => '#ffffff'
			)
		);
		//Field: Font Size
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'default_font_size',
				'type'    => 'text',
				'name'    => __( 'Allgemein: Schriftgröße', 'prt' ),
				'desc'    => __( 'Hier können Sie die allgemeine Schriftgröße abändern', 'prt' ),
				'default' => '14px'
			)
		);
		//Field: Font Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'default_font_color',
				'type'    => 'color',
				'name'    => __( 'Allgemein: Schriftfarbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die allgemeine Schriftfarbe abändern.', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: Font Transform
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'default_font_transform',
				'type'    => 'radio',
				'name'    => __( 'Allgemein: Schrifttransformation', 'prt' ),
				'desc'    => __( 'Hier können Sie bestimmen wie der Text transformiert weden soll', 'prt' ),
				'options' => array(
					'uppercase' => 'GROSSBUCHSTABEN',
					'lowercase' => 'kleinbuchstaben',
					'capitalize'=> 'Erster Buchstabe Groß',
					'none'		=> 'Keine Transformation'
				),
				'default' => 'none'
			)
		);
		//Field: Font Familiy
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'default_font_family',
				'type'    => 'googlefonts',
				'name'    => __( 'Allgemein: Schriftart', 'prt' ),
				'desc'    => __( 'Wählen Sie eine allgemeine Schriftart aus. Hierbei wird <a href="https://fonts.google.com">Google Fonts</a> verwendet', 'prt' ),
				'default' => 'Open Sans'
			)
		);
		//Field: Font Subset
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'default_font_subset',
				'type'    => 'select',
				'name'    => __( 'Allgemein: Schriftteilmenge', 'prt' ),
				'desc'    => __( 'Ändern Sie die den Zeichensatz der gewählten Schriftart ab.', 'prt' ),
				'default' => 'latin',
				'options' => array(
					'latin' => 'Latin (Empfohlen)',
					'latin-ext'  => 'Latin Extended',
					'greek'  => 'Greek',
					'greek-ext'  => 'Greek Extended',
					'cyrillic'  => 'Cyrillic',
					'cyrillic-ext'  => 'Cyrillic Extended',
					'vietnamese'  => 'Vietnamese'
				)
			)
		);
		//Field: Font Weight
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'default_font_weight',
				'type'    => 'radio',
				'name'    => __( 'Allgemein: Schriftstärke', 'prt' ),
				'desc'    => __( 'Hier können Sie die allgemeine Schriftstärke abändern.', 'prt' ),
				'options' => array(
					'300' => '<span style="font-weight:300">Light (300)</span>',
					'400' => '<span style="font-weight:400">Normal (400)</span>',
					'700' => '<span style="font-weight:700">Bold (700)</span>'
				),
				'default' => '400'
			)
		);

		$this->wposa->add_seperator('prt_settings_style');
		
		//Field: Button Prev Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'button_prev_color',
				'type'    => 'color',
				'name'    => __( 'Button (Vorheriges):  Farbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die Button-Farbe für "Zurück" abändern', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: Button Next Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'button_next_color',
				'type'    => 'color',
				'name'    => __( 'Button (Nächstes):  Farbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die Button-Farbe für "Weiter" abändern', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: Button Submit Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'button_finish_color',
				'type'    => 'color',
				'name'    => __( 'Button (Absenden):  Farbe', 'prt' ),
				'desc'    => __( 'Hier können Sie die Button-Farbe für "Absenden" abändern', 'prt' ),
				'default' => '#20bf6b'
			)
		);

		$this->wposa->add_seperator('prt_settings_style');

		//Field: H1 Size
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h1_size',
				'type'    => 'text',
				'name'    => __( 'Titel - H1: Schriftgröße', 'prt' ),
				'default' => 'inherit'
			)
		);
		//Field: H1 Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h1_color',
				'type'    => 'color',
				'name'    => __( 'Titel - H1: Farbe', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: H2 Size
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h2_size',
				'type'    => 'text',
				'name'    => __( 'Titel - H2: Schriftgröße', 'prt' ),
				'default' => 'inherit'
			)
		);
		//Field: H2 Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h2_color',
				'type'    => 'color',
				'name'    => __( 'Titel - H2: Farbe', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: H3 Size
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h3_size',
				'type'    => 'text',
				'name'    => __( 'Titel - H3: Schriftgröße', 'prt' ),
				'default' => 'inherit'
			)
		);
		//Field: H3 Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h3_color',
				'type'    => 'color',
				'name'    => __( 'Titel - H3: Farbe', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: H4 Size
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h4_size',
				'type'    => 'text',
				'name'    => __( 'Titel - H4: Schriftgröße', 'prt' ),
				'default' => 'inherit'
			)
		);
		//Field: H4 Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h4_color',
				'type'    => 'color',
				'name'    => __( 'Titel - H4: Farbe', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: H5 Size
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h5_size',
				'type'    => 'text',
				'name'    => __( 'Titel - H5: Schriftgröße', 'prt' ),
				'default' => 'inherit'
			)
		);
		//Field: H5 Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h5_color',
				'type'    => 'color',
				'name'    => __( 'Titel - H5: Farbe', 'prt' ),
				'default' => '#0A0A0A'
			)
		);
		//Field: H6 Size
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h6_size',
				'type'    => 'text',
				'name'    => __( 'Titel - H6: Schriftgröße', 'prt' ),
				'default' => 'inherit'
			)
		);
		//Field: H6 Color
		$this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'h6_color',
				'type'    => 'color',
				'name'    => __( 'Titel - H6: Farbe', 'prt' ),
				'default' => '#0A0A0A'
			)
		);

		$this->wposa->add_seperator('prt_settings_style');

		//Field: Custom CSS
        $this->wposa->add_field(
			'prt_settings_style',
			array(
				'id'      => 'custom_css',
				'type'    => 'textarea',
				'name'    => __( 'Eigenes CSS', 'prt' ),
				'desc'    => __( 'Hier können Sie Ihr eigenes CSS einfügen.', 'prt' ),
				'default' => '#thanks.for.using {}',
			)
		);
    }

    public function section_email() {
        //Section
        $this->wposa->add_section(
			array(
				'id'    => 'prt_settings_email',
				'title' => __( 'E-Mail', 'prt' ),
			)
		);

		$this->wposa->add_field(
			'prt_settings_email',
			array(
				'id'      => 'admin-email',
				'type'    => 'text',
				'name'    => __( 'Admin E-Mail Adresse', 'prt' ),
				'desc'    => __( 'An diese E-Mail werden Kundenanfragen mit der OpenImmo XML Datei als Anhang gesendet.', 'prt' ),
				'default' => 'info@makler-anfragen.immo'
			)
		);

		//Fields
		$this->wposa->add_field(
			'prt_settings_email',
			array(
				'id'      => 'email-subject-customer',
				'type'    => 'text',
				'name'    => __( 'E-Mail: Betreff (Kunde)', 'prt' ),
				'desc'    => __( 'Ändern Sie den Betreff der E-Mail, welche an den Kunden versendet wird. Die <b>Variablen</b> (unten) sind erlaubt.', 'prt' ),
				'default' => 'Ihre Immobilienbewertung {{ANREDE}} {{NACHNAME}}'
			)
		);
        
        $this->wposa->add_field(
			'prt_settings_email',
			array(
				'id'      => 'email-content-customer',
				'type'    => 'wysiwyg',
				'name'    => __( 'E-Mail: Inhalt (Kunde)', 'prt' ),
				'desc'    => __( 'Ändern Sie den Inhalt der E-Mail, welche an den Kunden versendet wird. Sie können diese <b>Variablen</b> nutzen:<br><br>
				{{IMMOBILIEN_TYP}}, {{ANREDE}}, {{VORNAME}}, {{NACHNAME}}, {{TELEFON}},<br>{{EMAIL}}, {{ADRESSE}}, {{WOHNFLACHE}}, {{ZIMMER}},<br>{{BAUJAHR}}, {{GRUNDFLACHE}}, {{ETAGE}}, {{ERSCHLOSSEN}},<br>{{BEBAUUNG}}, {{ZUSCHNITT}}, {{GESAMT_ERGEBNIS}}, {{MIN_GESAMT_ERGEBNIS}},<br>{{MAX_GESAMT_ERGEBNIS}}, {{ERGEBNIS_PRO_QM}}, {{MIN_ERGEBNIS_PRO_QM}}, {{MAX_ERGEBNIS_PRO_QM}}<br><i>QM bedeutet Quadrat Meter</i>', 'prt' ),
				'default' => '<p>Hallo {{ANREDE}} {{NACHNAME}},</p>
							<p>vielen Dank für Ihre Anfrage.</p>

							<p><strong>Wertermittlung</strong><br><br>
							  Ermittelter durchschnittlicher Marktwert: {{GESAMT_ERGEBNIS}}<br>
							  Durchschnittlicher Wert pro m² Wohnfläche: {{ERGEBNIS_PRO_QM}}<br>
							  Resultierende Wertspanne: {{MIN_GESAMT_ERGEBNIS}} - {{MAX_GESAMT_ERGEBNIS}}<br>
							  Ermittelte Wertspanne pro m²: {{MIN_ERGEBNIS_PRO_QM}} - {{MAX_ERGEBNIS_PRO_QM}}</p>

							<p><strong>Wie geht es weiter?</strong><br></p>
							<ol>
							  <li>Wir rufen Sie in Kürze an, um die individuellen Gegebenheiten Ihrer Immobilie zu ermitteln.</li>
							  <li>Sie erhalten anschließend eine detaillierte Immobilienbewertung von uns per E-Mail zugeschickt.</li>
							  <li>Sie prüfen die Immobilienbewertung und entscheiden selbst, ob Sie uns mit der Vermarktung beauftragen.</li>
							</ol>
							<p><strong>Unsere Immobilienbewertung ist für Sie selbstverständlich kostenlos.</strong></p>
							<p>Für Rückfragen stehen wir Ihnen sehr gerne zur Verfügung.</p>
							<p>Mit freundlichen Grüßen<br>
							 Ihr Team von Max Mustermakler</p>',
			)
		);

		$this->wposa->add_seperator('prt_settings_email');

		$this->wposa->add_field(
			'prt_settings_email',
			array(
				'id'      => 'email-subject-admin',
				'type'    => 'text',
				'name'    => __( 'E-Mail: Betreff (Admin)', 'prt' ),
				'desc'    => __( 'Ändern Sie den Betreff der E-Mail, welche an den Kunden versendet wird. Die <b>Variablen</b> (unten) sind erlaubt.', 'prt' ),
				'default' => 'Neuer Lead: {{VORNAME}} {{NACHNAME}}'
			)
		);
        
        $this->wposa->add_field(
			'prt_settings_email',
			array(
				'id'      => 'email-content-admin',
				'type'    => 'wysiwyg',
				'name'    => __( 'E-Mail: Inhalt (Admin)', 'prt' ),
				'desc'    => __( 'Ändern Sie den Inhalt der E-Mail, welche an den Administrator versendet wird. Sie können diese <b>Variablen</b> nutzen:<br><br>
				{{IMMOBILIEN_TYP}}, {{ANREDE}}, {{VORNAME}}, {{NACHNAME}}, {{TELEFON}},<br>{{EMAIL}}, {{ADRESSE}}, {{WOHNFLACHE}}, {{ZIMMER}},<br>{{BAUJAHR}}, {{GRUNDFLACHE}}, {{ETAGE}}, {{ERSCHLOSSEN}},<br>{{BEBAUUNG}}, {{ZUSCHNITT}}, {{GESAMT_ERGEBNIS}}, {{MIN_GESAMT_ERGEBNIS}},<br>{{MAX_GESAMT_ERGEBNIS}}, {{ERGEBNIS_PRO_QM}}, {{MIN_ERGEBNIS_PRO_QM}}, {{MAX_ERGEBNIS_PRO_QM}}<br><i>QM bedeutet Quadrat Meter</i>', 'prt' ),
                'default' => '<p>Anbei erhalten Sie eine Eigentümer-Anfrage von der Immobilienbewertung Ihrer Homepage.<br>
							  <br>
							  Bitte setzen Sie sich schnellstmöglich mit dem Eigentümer in Verbindung. Der Eigentümer  hat der Kontaktaufnahme ausdrücklich zugestimmt.<br>
							</p>
							<p><strong>Kontaktinformationen</strong><br>
							  Kontakt: {{ANREDE}} {{VORNAME}} {{NACHNAME}}<br>
							  Telefonnummer: {{TELEFON}}<br>
							  E-Mail-Adresse: {{EMAIL}}
							</p>

							<p><strong>Objektinformationen</strong><br>
							  Objektadresse: {{ADRESSE}}<br>
							  Immobilientyp: {{IMMOBILIEN_TYP}}<br>
							  Baujahr: {{BAUJAHR}}<br>
							  Wohnfläche: {{WOHNFLACHE}}m²<br>
							  Grundstücksfläche: {{GRUNDFLACHE}}m²<br>
							  Etagenanzahl: {{ETAGE}}<br>
							  Zimmeranzahl: {{ZIMMER}}<br>
							  Gebäudeart: {{BEBAUUNG}}</p>

							<p><strong>Wertermittlung</strong><br>
							  Ermittelter durchschnittlicher Marktwert: {{GESAMT_ERGEBNIS}}<br>
							  Durchschnittlicher Wert pro m² Wohnfläche: {{ERGEBNIS_PRO_QM}}<br>
							  Resultierende Wertspanne: {{MIN_GESAMT_ERGEBNIS}} - {{MAX_GESAMT_ERGEBNIS}}<br>
							  Ermittelte Wertspanne pro m²: {{MIN_ERGEBNIS_PRO_QM}} - {{MAX_ERGEBNIS_PRO_QM}}</p>',
			)
		);
	}
	
	/**
	 * Get the value of a settings field
	 *
	 * @param string  $option  settings field name
	 * @param string  $section the section name this field belongs to
	 * @param string  $default default text if it's not found
	 * @return string
	 */
	function get_option( $option, $section, $default = '' ) {
	    return $this->wposa->get_option($option, $section, $default);
	}

}