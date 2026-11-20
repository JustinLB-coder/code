<?php
/**
 * Plugin Name: Assistant Chez Soie
 * Description: Bulle de clavardage IA qui répond aux questions fréquentes et invite à appeler la clinique. Mode « administrateurs seulement » pour les essais.
 * Version: 0.2.0
 * Author: Chez Soie dentisterie
 * Text Domain: chezsoie-assistant
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CSA_VERSION', '0.2.0' );
define( 'CSA_MODEL', 'claude-opus-5-5' );
define( 'CSA_DEFAULT_PHONE', '450 455-5671' );
define( 'CSA_DEFAULT_KB', 'CLINIQUE
- Nom : Chez Soie dentisterie. Anciennement Marcotte médecine dentaire; la Clinique dentaire Charles Trottier s\'est aussi jointe à nous. Les deux équipes travaillent ensemble à la même adresse.
- Clinique familiale à Vaudreuil-Dorion depuis 1980. Adultes et enfants.
- Adresse : Polyclinique médicale de Vaudreuil-Dorion, 600, boulevard Harwood, bureau 300, Vaudreuil-Dorion (Québec) J7V 6A3
- Courriel : info@chezsoiedentisterie.com
- Stationnement gratuit sur place. Chantiers autour de la clinique : prévoir quelques minutes de plus.
- Accessible en fauteuil roulant, avec ascenseur.
- Services en français et en anglais.
- Secteurs : Vaudreuil-Dorion, L\'Île-Perrot, Pincourt, Notre-Dame-de-l\'Île-Perrot, Saint-Lazare, Hudson, Les Cèdres, Vaudreuil-sur-le-Lac.

HEURES D\'OUVERTURE
- Lundi et mardi : 7 h 30 à 18 h
- Mercredi : 7 h 30 à 19 h
- Jeudi : 7 h 30 à 17 h
- Vendredi : 7 h 30 à 15 h 30
- Samedi et dimanche : fermé

PRENDRE RENDEZ-VOUS
- Le plus simple : appeler pendant les heures d\'ouverture.
- Réservation en ligne : pas encore offerte, le service arrivera prochainement. Pour le moment, le plus simple est d\'appeler pendant les heures d\'ouverture ou d\'écrire à info@chezsoiedentisterie.com.
- Nous acceptons les nouveaux patients de tous âges, adultes et enfants.
- Premier rendez-vous, apporter : carte d\'assurance maladie, liste des médicaments, carte d\'assurance dentaire ou numéro de membre du RCSD si applicable.
- Patients anxieux : le dire en prenant rendez-vous. Hypnose dentaire et sédation consciente offertes.

URGENCES
- Plages réservées chaque jour pour les urgences (mal de dents, dent cassée, abcès, enflure, plombage perdu). Appeler dès l\'ouverture : dans la plupart des cas, on peut vous voir le jour même.
- RCSD accepté aussi pour les urgences.
- Clinique fermée : enflure importante au visage, difficulté à respirer ou à avaler → urgence de l\'hôpital ou 911. Douleur qui peut attendre → appeler à l\'ouverture.
- Conseils généraux en attendant (pas un diagnostic) : dent cassée ou plombage perdu, éviter de mâcher de ce côté et les aliments très chauds ou froids. Couronne tombée, la garder et l\'apporter. Enflure, compresse froide sur la joue.

ASSURANCES ET PAIEMENT
- RCSD (Régime canadien de soins dentaires) : accepté, facturation directe au régime. Les tarifs du RCSD sont plus bas que les honoraires au Québec, donc il reste presque toujours une balance à payer. Le montant est indiqué avant chaque traitement.
- Assurances privées : réclamations envoyées directement à l\'assureur.
- Enfants de moins de 10 ans : la RAMQ couvre plusieurs soins (examen annuel, radiographies, obturations). Première visite recommandée entre 1 et 3 ans.
- Financement : prêts sur mesure à l\'interne ou par un prêteur externe spécialisé (Dentalcard, www.dentalcard.ca). Demander au moment du plan de traitement.

SERVICES
- Dentisterie générale et familiale : examens, nettoyages (détartrage), radiographies numériques, obturations, scellants, protecteurs buccaux
- Traitements de canal, couronnes, ponts, facettes, blanchiment, fermeture de diastème
- Implants dentaires et réhabilitation complète (Dr Charles Trottier, expertise en implantologie)
- Chirurgie : extractions, dents de sagesse, greffes gingivales
- Traitement des gencives (parodontie)
- Orthodontie : offerte par Dr Justin L. Bombardier, dentiste généraliste qui fait de l\'orthodontie (il n\'est PAS orthodontiste). Coquilles d\'alignement (quasi invisibles), broches, appareils amovibles.
- Denturologie : prothèses complètes, partielles et sur implants (Isabelle Choquette, denturologiste)
- Neuromodulateurs (Botox) : permis aux dentistes formés depuis juin 2025 par l\'Ordre des dentistes du Québec. Pour le grincement des dents (bruxisme), tensions et douleurs à la mâchoire, parfois migraines, et esthétique (lignes d\'expression). Commence par une consultation.
- Hypnose dentaire et sédation consciente pour les patients anxieux
- Traitement de l\'apnée du sommeil et du ronflement

ÉQUIPE
- Dentistes : Dr Justin L. Bombardier, Dre Sabrina Berthiaume, Dr Marc Iskandar, Dre Lauren Li, Dr Charles Trottier
- Denturologiste : Isabelle Choquette
- Une équipe d\'hygiénistes dentaires et de coordonnatrices de plan de traitement

CONSULTATIONS
- Pour la plupart des consultations, des frais d\'examen particulier sont facturés.
- Exception : la consultation en orthodontie avec Dr Justin L. Bombardier est gratuite.

PRIX
- Aucun prix par clavardage : chaque cas est différent. L\'équipe donne une estimation au téléphone ou lors du plan de traitement.' );
define( 'CSA_JOBS_KB', 'EMPLOIS CHEZ SOIE
- Une grande équipe soudée où l\'entraide est priorisée et le travail de chacun est valorisé.
- Tous les services de dentisterie sous le même toit, dans une ambiance décontractée, chaleureuse et humaine.
- Équipe actuelle : 5 dentistes, une denturologiste, une équipe d\'hygiénistes dentaires, des coordonnatrices de plan de traitement, une gestionnaire de clinique.
- Clinique familiale à Vaudreuil-Dorion depuis 1980, à la Polyclinique médicale (600, boul. Harwood, bureau 300). Stationnement gratuit.
- Pour postuler ou poser une question sur un emploi : écrire à Mélissa, gestionnaire de clinique, melissa@chezsoiedentisterie.com (joindre son CV).
- Postes : nous recueillons en tout temps les CV pour tous les postes, soit réceptionniste, assistante dentaire, hygiéniste dentaire et dentiste.
- Salaires, horaires et avantages ne sont pas listés ici : Mélissa pourra en parler.' );

/* ------------------------------------------------------------------ *
 * Settings
 * ------------------------------------------------------------------ */

function csa_opt( $key, $default = '' ) {
	$opts = get_option( 'csa_settings', array() );
	return isset( $opts[ $key ] ) && '' !== $opts[ $key ] ? $opts[ $key ] : $default;
}

/** API key: wp-config.php constant first (recommended), then the settings field. */
function csa_api_key() {
	if ( defined( 'CHEZSOIE_ANTHROPIC_KEY' ) && CHEZSOIE_ANTHROPIC_KEY ) {
		return CHEZSOIE_ANTHROPIC_KEY;
	}
	return csa_opt( 'api_key' );
}

/** 'admins' (default) or 'public'. */
function csa_mode() {
	return 'public' === csa_opt( 'mode', 'admins' ) ? 'public' : 'admins';
}

function csa_visible_to_current_user() {
	return 'public' === csa_mode() || current_user_can( 'manage_options' );
}

add_action( 'admin_menu', function () {
	add_options_page( 'Assistant Chez Soie', 'Assistant Chez Soie', 'manage_options', 'chezsoie-assistant', 'csa_settings_page' );
} );

add_action( 'admin_init', function () {
	register_setting( 'csa_settings_group', 'csa_settings', array(
		'type'              => 'array',
		'sanitize_callback' => function ( $in ) {
			$old = get_option( 'csa_settings', array() );
			$out = array();
			$out['mode']  = ( isset( $in['mode'] ) && 'public' === $in['mode'] ) ? 'public' : 'admins';
			$out['auto_open'] = ( isset( $in['auto_open'] ) && in_array( $in['auto_open'], array( 'desktop', 'all', 'none' ), true ) ) ? $in['auto_open'] : 'desktop';
			$out['phone'] = isset( $in['phone'] ) ? sanitize_text_field( $in['phone'] ) : CSA_DEFAULT_PHONE;
			$out['kb']    = isset( $in['kb'] ) ? sanitize_textarea_field( $in['kb'] ) : '';
			// Keep the stored key when the field is left blank.
			$key = isset( $in['api_key'] ) ? trim( sanitize_text_field( $in['api_key'] ) ) : '';
			$out['api_key'] = '' !== $key ? $key : ( isset( $old['api_key'] ) ? $old['api_key'] : '' );
			return $out;
		},
	) );
} );

function csa_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$has_const = defined( 'CHEZSOIE_ANTHROPIC_KEY' ) && CHEZSOIE_ANTHROPIC_KEY;
	$has_key   = '' !== csa_api_key();
	?>
	<div class="wrap">
		<h1>Assistant Chez Soie</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'csa_settings_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">Visibilité</th>
					<td>
						<label><input type="radio" name="csa_settings[mode]" value="admins" <?php checked( csa_mode(), 'admins' ); ?>> Administrateurs connectés seulement (essais)</label><br>
						<label><input type="radio" name="csa_settings[mode]" value="public" <?php checked( csa_mode(), 'public' ); ?>> Tous les visiteurs du site</label>
					</td>
				</tr>
				<tr>
					<th scope="row">Ouverture automatique</th>
					<td>
						<?php $ao = csa_opt( 'auto_open', 'desktop' ); ?>
						<label><input type="radio" name="csa_settings[auto_open]" value="desktop" <?php checked( $ao, 'desktop' ); ?>> Sur ordinateur seulement (recommandé : sur cellulaire, la fenêtre couvrirait la page)</label><br>
						<label><input type="radio" name="csa_settings[auto_open]" value="all" <?php checked( $ao, 'all' ); ?>> Sur ordinateur et cellulaire</label><br>
						<label><input type="radio" name="csa_settings[auto_open]" value="none" <?php checked( $ao, 'none' ); ?>> Jamais (le visiteur clique sur la bulle)</label>
						<p class="description">Si le visiteur ferme la fenêtre, elle ne se rouvre plus d'elle-même pendant sa visite.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="csa_key">Clé API Anthropic</label></th>
					<td>
						<?php if ( $has_const ) : ?>
							<p>✔ Clé définie dans wp-config.php (CHEZSOIE_ANTHROPIC_KEY).</p>
						<?php else : ?>
							<input type="password" id="csa_key" name="csa_settings[api_key]" class="regular-text" autocomplete="off" placeholder="<?php echo $has_key ? '•••••••• (enregistrée, laisser vide pour la garder)' : 'sk-ant-…'; ?>">
							<p class="description">Recommandé : mettre plutôt <code>define( 'CHEZSOIE_ANTHROPIC_KEY', 'sk-ant-…' );</code> dans wp-config.php.</p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="csa_phone">Téléphone</label></th>
					<td><input type="text" id="csa_phone" name="csa_settings[phone]" class="regular-text" value="<?php echo esc_attr( csa_opt( 'phone', CSA_DEFAULT_PHONE ) ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="csa_kb">Fiche FAQ</label></th>
					<td>
						<textarea id="csa_kb" name="csa_settings[kb]" rows="24" class="large-text code"><?php echo esc_textarea( csa_opt( 'kb', CSA_DEFAULT_KB ) ); ?></textarea>
						<p class="description">L'assistant répond seulement à partir de cette fiche. Videz le champ et enregistrez pour revenir à la fiche d'origine.</p>
					</td>
				</tr>
			</table>
			<?php submit_button( 'Enregistrer' ); ?>
		</form>
	</div>
	<?php
}

/* ------------------------------------------------------------------ *
 * Front end
 * ------------------------------------------------------------------ */

add_action( 'wp_enqueue_scripts', function () {
	if ( is_admin() || ! csa_visible_to_current_user() ) {
		return;
	}
	$base = plugin_dir_url( __FILE__ ) . 'assets/';
	wp_enqueue_style( 'csa-widget', $base . 'widget.css', array(), CSA_VERSION );
	wp_enqueue_script( 'csa-widget', $base . 'widget.js', array(), CSA_VERSION, true );
	wp_localize_script( 'csa-widget', 'CSA_CONFIG', array(
		'endpoint' => esc_url_raw( rest_url( 'chezsoie/v1/chat' ) ),
		'nonce'    => wp_create_nonce( 'wp_rest' ),
		'phone'    => csa_opt( 'phone', CSA_DEFAULT_PHONE ),
		'testMode' => 'admins' === csa_mode(),
		'autoOpen' => csa_opt( 'auto_open', 'desktop' ),
	) );
} );

/* ------------------------------------------------------------------ *
 * REST endpoint: POST /wp-json/chezsoie/v1/chat
 * ------------------------------------------------------------------ */

add_action( 'rest_api_init', function () {
	register_rest_route( 'chezsoie/v1', '/chat', array(
		'methods'             => 'POST',
		'callback'            => 'csa_handle_chat',
		'permission_callback' => 'csa_visible_to_current_user',
	) );
} );

/** Simple per-IP limit for public mode: 30 messages per 10 minutes. */
function csa_rate_limited() {
	if ( current_user_can( 'manage_options' ) ) {
		return false;
	}
	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'x';
	$key = 'csa_rl_' . md5( $ip );
	$n   = (int) get_transient( $key );
	if ( $n >= 30 ) {
		return true;
	}
	set_transient( $key, $n + 1, 10 * MINUTE_IN_SECONDS );
	return false;
}

function csa_handle_chat( WP_REST_Request $req ) {
	$phone = csa_opt( 'phone', CSA_DEFAULT_PHONE );
	$fail  = sprintf( "Désolé, je ne peux pas répondre pour le moment. Appelez-nous au %s. / Sorry, I can't answer right now. Please call us at %s.", $phone, $phone );

	if ( csa_rate_limited() ) {
		return new WP_REST_Response( array( 'reply' => $fail ), 429 );
	}
	$key = csa_api_key();
	if ( '' === $key ) {
		return new WP_REST_Response( array( 'reply' => 'Clé API manquante : Réglages > Assistant Chez Soie.' ), 500 );
	}

	// Validate the conversation sent by the browser.
	$raw   = $req->get_param( 'messages' );
	$page  = 'emplois' === $req->get_param( 'page' ) ? 'emplois' : 'accueil';
	$turns = array();
	if ( is_array( $raw ) ) {
		foreach ( array_slice( $raw, -14 ) as $m ) {
			if ( ! is_array( $m ) || empty( $m['content'] ) || ! in_array( $m['role'] ?? '', array( 'user', 'assistant' ), true ) ) {
				continue;
			}
			$turns[] = array(
				'role'    => $m['role'],
				'content' => mb_substr( sanitize_textarea_field( (string) $m['content'] ), 0, 1500 ),
			);
		}
	}
	while ( $turns && 'user' !== $turns[0]['role'] ) {
		array_shift( $turns );
	}
	if ( ! $turns || 'user' !== end( $turns )['role'] ) {
		return new WP_REST_Response( array( 'reply' => $fail ), 400 );
	}

	$rules = 'emplois' === $page ? csa_jobs_rules( $phone ) : csa_patient_rules( $phone );
	$now   = csa_now_quebec();

	$body = array(
		'model'         => CSA_MODEL,
		'max_tokens'    => 4000,
		'output_config' => array( 'effort' => 'low' ),
		'fallbacks'     => 'default',
		'system'        => array(
			// Stable part first and cached; the clock goes after the cache breakpoint.
			array( 'type' => 'text', 'text' => $rules, 'cache_control' => array( 'type' => 'ephemeral' ) ),
			array( 'type' => 'text', 'text' => 'DATE ET HEURE ACTUELLES (heure du Québec) : ' . $now ),
		),
		'messages'      => $turns,
	);

	$res = wp_remote_post( 'https://api.anthropic.com/v1/messages', array(
		'timeout' => 45,
		'headers' => array(
			'content-type'      => 'application/json',
			'x-api-key'         => $key,
			'anthropic-version' => '2026-10-21',
			'anthropic-beta'    => 'server-side-fallback-2026-07-01',
		),
		'body'    => wp_json_encode( $body ),
	) );

	if ( is_wp_error( $res ) ) {
		return new WP_REST_Response( array( 'reply' => $fail ), 502 );
	}
	$code = wp_remote_retrieve_response_code( $res );
	$data = json_decode( wp_remote_retrieve_body( $res ), true );
	if ( 200 !== $code || ! is_array( $data ) ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( 'Assistant Chez Soie: API HTTP ' . $code . ' ' . substr( wp_remote_retrieve_body( $res ), 0, 300 ) );
		}
		return new WP_REST_Response( array( 'reply' => $fail ), 502 );
	}
	if ( ( $data['stop_reason'] ?? '' ) === 'refusal' ) {
		return new WP_REST_Response( array( 'reply' => $fail ), 200 );
	}
	$text = '';
	foreach ( (array) ( $data['content'] ?? array() ) as $block ) {
		if ( ( $block['type'] ?? '' ) === 'text' ) {
			$text .= $block['text'];
		}
	}
	$text = trim( $text );
	return new WP_REST_Response( array( 'reply' => '' !== $text ? $text : $fail ), 200 );
}

function csa_now_quebec() {
	try {
		$d = new DateTime( 'now', new DateTimeZone( 'America/Toronto' ) );
	} catch ( Exception $e ) {
		$d = new DateTime();
	}
	$days = array( 'dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi' );
	return $days[ (int) $d->format( 'w' ) ] . ' ' . $d->format( 'Y-m-d H:i' );
}

function csa_patient_rules( $phone ) {
	$kb = csa_opt( 'kb', CSA_DEFAULT_KB );
	return "Tu es l'assistant virtuel du site web de la clinique dentaire Chez Soie dentisterie. Tu réponds aux visiteurs dans la fenêtre de clavardage du site.

BUT : répondre aux questions fréquentes et amener le visiteur à APPELER la clinique pour prendre rendez-vous.

FICHE DE LA CLINIQUE (ta seule source d'information) :
Téléphone : {$phone}
{$kb}

RÈGLES :
1. Langue : réponds dans la langue du visiteur (français par défaut, anglais s'il écrit en anglais). Vouvoie en français.
2. Sois bref et chaleureux : 2 à 4 phrases courtes. Pas de titres, pas de markdown, pas d'émojis. Une liste courte seulement pour les heures.
3. Termine presque toujours par une invitation claire à appeler, avec le numéro : {$phone}. Si la clinique est fermée en ce moment (selon l'heure actuelle et les heures d'ouverture), dis quand elle rouvre.
4. N'invente jamais d'information absente de la fiche (prix, noms, assurances précises, etc.). Dis simplement que l'équipe pourra répondre au téléphone.
5. Aucun diagnostic ni conseil de traitement. Pour une douleur, un saignement, une enflure, une dent cassée : dis que c'est une bonne raison de consulter, d'appeler la clinique dès que possible (plages d'urgence), et, si les symptômes sont graves (enflure qui gêne la respiration ou la déglutition, fièvre importante, traumatisme au visage, saignement qui ne s'arrête pas), d'aller à l'urgence de l'hôpital ou d'appeler le 911.
6. Ne demande jamais de renseignements de santé, de numéro d'assurance maladie ou de coordonnées. Si le visiteur en donne, ne les répète pas.
7. RCSD/CDCP : on accepte ces patients, mais ne dis jamais que c'est gratuit ou couvert à 100 %. Le seul service gratuit est la consultation en orthodontie avec Dr Justin L. Bombardier; pour toute autre consultation, explique que des frais d'examen particulier sont facturés.
8. Pas de comparaison avec d'autres dentistes, pas de garanties de résultat, pas de témoignages.
9. Dr Justin L. Bombardier est un dentiste généraliste qui offre l'orthodontie : ne le présente jamais comme orthodontiste ou spécialiste.
10. Réservation en ligne : pas encore offerte, elle arrivera prochainement. Pour le moment, appeler pendant les heures d'ouverture ou écrire à info@chezsoiedentisterie.com.
11. Si la question n'a aucun lien avec la clinique ou la santé dentaire, ramène poliment la conversation vers la clinique.";
}

function csa_jobs_rules( $phone ) {
	$kb   = csa_opt( 'kb', CSA_DEFAULT_KB );
	$jobs = CSA_JOBS_KB;
	return "Tu es l'assistant virtuel du site web de la clinique dentaire Chez Soie dentisterie. Le visiteur est sur la page EMPLOIS : c'est probablement un futur employé potentiel (hygiéniste, assistante dentaire, réceptionniste, dentiste, etc.).

BUT : lui donner envie de se joindre à l'équipe et l'amener à écrire à Mélissa, gestionnaire de clinique, à melissa@chezsoiedentisterie.com avec son CV.

INFORMATION SUR LES EMPLOIS :
{$jobs}

INFORMATION SUR LA CLINIQUE (si utile) :
{$kb}

RÈGLES :
1. Réponds dans la langue du visiteur (français par défaut, anglais s'il écrit en anglais). Vouvoie en français.
2. Sois bref, chaleureux et enthousiaste : 2 à 4 phrases courtes. Pas de titres, pas de markdown, pas d'émojis.
3. Termine presque toujours en invitant à écrire à Mélissa : melissa@chezsoiedentisterie.com.
4. Si on demande quels postes sont ouverts, réponds toujours que nous recueillons les CV pour tous les postes (réceptionniste, assistante dentaire, hygiéniste dentaire, dentiste) et invite à envoyer son CV à Mélissa. Ne dis jamais qu'un poste précis est ouvert ou comblé. N'invente pas de salaires, d'horaires de travail ou d'avantages sociaux : Mélissa pourra en parler.
5. Ne demande pas de renseignements personnels (CV, téléphone, adresse) dans le clavardage : le CV s'envoie par courriel.
6. Si le visiteur est plutôt un patient (rendez-vous, douleur, question de soins), réponds comme pour un patient et donne le numéro de la clinique : {$phone}.";
}
