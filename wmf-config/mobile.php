<?php

# WARNING: This file is publically viewable on the web.
# # Do not put private data here.

if ( $wmgMobileFrontend ) {
	require_once( "$IP/extensions/MobileFrontend/MobileFrontend.php" );
	$wgMFMobileHeader = 'X-Subdomain';
	$wgMFNoindexPages = false;
	$wgMFNearby = $wmgMFNearby && $wmgEnableGeoData;
	$wgMFPhotoUploadEndpoint = $wmgMFPhotoUploadEndpoint;
	$wgMFUseCentralAuthToken = $wmgMFUseCentralAuthToken;
	$wgMFPhotoUploadWiki = $wmgMFPhotoUploadWiki;
	$wgMFContentNamespace = $wmgMFContentNamespace;
	$wgMFPhotoUploadAppendToDesc = $wmgMFPhotoUploadAppendToDesc;
	$wgMFUseWikibaseDescription = $wmgMFUseWikibaseDescription;

	if ( $wmgMobileFrontendLogo ) {
		$wgMobileFrontendLogo = $wmgMobileFrontendLogo;
	}
	if ( $wmgMFCustomLogos ) {
		if ( isset( $wmgMFCustomLogos['copyright'] ) ) {
			$wmgMFCustomLogos['copyright'] = str_replace( '{wgExtensionAssetsPath}', $wgExtensionAssetsPath, $wmgMFCustomLogos['copyright'] );
		}
		$wgMFCustomLogos = $wmgMFCustomLogos;
	}

	// If a URL template is set for MobileFrontend, use it.
	if ( $wmgMobileUrlTemplate ) {
		$wgMobileUrlTemplate = $wmgMobileUrlTemplate;
	}

	$wgMFAutodetectMobileView = $wmgMFAutodetectMobileView;

	if ( $wmgZeroBanner && !$wmgZeroPortal ) {
		require_once( "$IP/extensions/JsonConfig/JsonConfig.php" );
		require_once( "$IP/extensions/ZeroBanner/ZeroBanner.php" );

		$wgJsonConfigs['JsonZeroConfig']['remote'] = array(
			'url' => 'https://zero.wikimedia.org/w/api.php',
			'username' => $wmgZeroPortalApiUserName,
			'password' => $wmgZeroPortalApiPassword,
		);

		// @TODO: which group(s) on all wikies should Zero allow to flush cache?
		$wgGroupPermissions['sysop']['jsonconfig-flush'] = true;
		// $wgZeroBannerFont = '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSans.ttf';
		// $wgZeroBannerFontSize = '10';
	}

	// Enable loading of desktop-specific resources from MobileFrontend
	if ( $wmgMFEnableDesktopResources ) {
		$wgMFEnableDesktopResources = true;
	}

	// Enable appending of TM (text) / (R) (icon) on site name in footer.
	$wgMFTrademarkSitename = $wmgMFTrademarkSitename;

	// Enable X-Analytics logging
	$wgMFEnableXAnalyticsLogging = $wmgMFEnableXAnalyticsLogging;

	// Blacklist some pages
	$wgMFNoMobileCategory = $wmgMFNoMobileCategory;
	$wgMFNoMobilePages = $wmgMFNoMobilePages;

	$wgHooks['EnterMobileMode'][] = function() {
		global $wgCentralAuthCookieDomain, $wgExtensionAssetsPath,
			$wgLoadScript, $wgResourceBasePath, $wgStylePath, $wgStyleSheetPath;

		$mobileContext = MobileContext::singleton();
		$wgExtensionAssetsPath = $mobileContext->getMobileUrl( $wgExtensionAssetsPath );
		$wgLoadScript = $mobileContext->getMobileUrl( $wgLoadScript );
		$wgResourceBasePath = $mobileContext->getMobileUrl( $wgResourceBasePath );
		$wgStyleSheetPath = $mobileContext->getMobileUrl( $wgStyleSheetPath );
		$wgStylePath = $wgStyleSheetPath;

		// Hack for T49647
		if ( $wgCentralAuthCookieDomain == 'commons.wikimedia.org' ) {
			$wgCentralAuthCookieDomain = 'commons.m.wikimedia.org';
		} elseif ( $wgCentralAuthCookieDomain == 'meta.wikimedia.org' ) {
			$wgCentralAuthCookieDomain = 'meta.m.wikimedia.org';
		}

		return true;
	};

	$wgMFEnableSiteNotice = $wmgMFEnableSiteNotice;
	$wgMFCollapseSectionsByDefault = $wmgMFCollapseSectionsByDefault;
	$wgMFTidyMobileViewSections = false; // experimental

	// Link to help Google spider associate pages on wiki with our Android app.
	// They originally special-cased us but would like it done the normal way now. :)
	$wgMFAppPackageId = $wmgMFAppPackageId;
	$wgMFNearbyRange = $wmgMaxGeoSearchRadius;

	$wgMFPageActions = array_diff( $wgMFPageActions, $wmgMFRemovePageActions );

	// restrict access to mobile Uploads to users with minimum editcount T64598
	$wgMFUploadMinEdits = $wmgMFUploadMinEdits;

	// Disable mobile uploads per T64598
	$wgGroupPermissions['autoconfirmed']['mf-uploadbutton'] = false;
	$wgGroupPermissions['sysop']['mf-uploadbutton'] = false;

	$wgMFEnableBeta = true;

	// enable editing for unregistered users
	$wgMFEditorOptions = $wmgMFEditorOptions;

	$wgMFUseWikibaseDescription = true; // Alpha experiment

	// Turn on volunteer recruitment
	$wgMFEnableJSConsoleRecruitment = true;

	if ( $wmgUseGather ) {
		require_once "$IP/extensions/Gather/Gather.php";
	}

	// Enable browse experiment (T101155)
	$wgMFIsBrowseEnabled = $wmgMFIsBrowseEnabled;
	$wgMFBrowseTags = array();

	if ( $wgMFIsBrowseEnabled ) {
		$wgMFBrowseTags = array(
			'San Francisco landmarks' => array(
				'Alcatraz Island',
				'Golden Gate Bridge',
				'Presidio of San Francisco',
				'Lombard Street (San Francisco)',
				'Golden Gate Park',
				'City Lights Bookstore',
				'Coit Tower',
				'San Francisco cable car system',
				'Palace of Fine Arts',
				'Alamo Square, San Francisco',
				'Fort Point, San Francisco',
				'Grace Cathedral, San Francisco',
				'San Francisco Ferry Building',
				'AT&T Park',
				'Yerba Buena Gardens',
				'Castro Theatre',
				'Transamerica Pyramid',
				'San Francisco Museum of Modern Art',
				'Candlestick Park',
				'San Francisco Zoo',
				'Fairmont San Francisco',
				'Fort Mason',
				'Ghirardelli Square',
				'Crissy Field',
				'San Francisco Botanical Garden',
				'Barbary Coast Trail',
				'Duboce Park',
				'Flatiron Building (San Francisco)',
				'Lands End (San Francisco)',
				'San Francisco Mint',
				'Crissy Field',
				'San Francisco Naval Shipyard',
				'Dolores Park',
				'Jack Kerouac Alley',
				'San Francisco Cable Car Museum',
				'Balboa Park, San Francisco',
				'Panhandle (San Francisco)',
				'San Francisco City Hall',
				'Victoria Theatre, San Francisco',
				'Union Square, San Francisco',
				'San Francisco Armory',
				'Mitchell Brothers O\'Farrell Theatre',
				'Seal Rocks (San Francisco, California)',
				'San Francisco–Oakland Bay Bridge',
				'Asian Art Museum of San Francisco',
				'San Francisco Public Library',
				'Levi\'s Plaza',
				'Louise M. Davies Symphony Hall',
				'Moscone Center',
				'San Francisco Federal Building',
			),
			'western Europe' => array(
				'Germany',
				'France',
				'United Kingdom',
				'Italy',
				'Spain',
				'Netherlands',
				'Belgium',
				'Greece',
				'Portugal',
				'Sweden',
				'Austria',
				'Switzerland',
				'Denmark',
				'Finland',
				'Norway',
				'Ireland',
				'Luxembourg',
				'Iceland',
				'Vatican City',
				'Monaco',
				'Principality of Sealand',
				'Western Europe',
				'Northwestern Europe',
			),
			'American politicians of the 20th century' => array(
				'Barack Obama',
				'George W. Bush',
				'Franklin D. Roosevelt',
				'Ronald Reagan',
				'George Washington',
				'Bill Clinton',
				'Theodore Roosevelt',
				'John F. Kennedy',
				'Woodrow Wilson',
				'Richard Nixon',
				'Jimmy Carter',
				'Martin Luther King Jr.',
				'John Kerry',
				'Dwight D. Eisenhower',
				'Lyndon B. Johnson',
				'Harry S. Truman',
				'George H. W. Bush',
				'John McCain',
				'Hillary Rodham Clinton',
				'Al Gore',
				'Nancy Pelosi',
				'Harry Reid',
				'Gerald Ford',
				'Calvin Coolidge',
				'John Boehner',
				'Henry Kissinger',
				'Eric Cantor',
				'Mitch McConnell',
				'Herbert Hoover',
				'Arnold Schwarzenegger',
				'Mitt Romney',
				'Condoleezza Rice',
				'Warren G. Harding',
				'Joe Biden',
				'William McKinley',
				'Colin Powell',
				'Michael Bloomberg',
				'Dick Cheney',
				'William Randolph Hearst',
				'Donald Rumsfeld',
				'Ted Kennedy',
				'Robert F. Kennedy',
				'Robert McNamara',
				'Cordell Hull',
				'John Foster Dulles',
				'James Buchanan',
				'Cordell Hull',
				'Jerry Brown',
				'James A. Garfield',
				'Ralph Nader',
				'Robert Gates',
				'George Marshall',
				'Martin Van Buren',
				'John Kenneth Galbraith',
				'Ralph Nader',
				'Robert Gates',
				'George Marshall',
				'Rudy Giuliani',
				'Madeleine Albright',
				'Ben Bernanke',
				'Barry Goldwater',
				'Nelson Rockefeller',
				'Ron Paul',
				'Jesse Jackson',
				'James Baker',
				'Fiorello H. La Guardia',
				'Newt Gingrich',
				'Sarah Palin',
				'William Cohen',
				'Joseph McCarthy',
				'Ross Perot',
				'Malcolm X',
				'Chuck Schumer',
				'Zbigniew Brzezinski',
				'Dianne Feinstein',
			),
			'modern painters' => array(
				'Pablo Picasso',
				'Willem de Kooning',
				'Marc Chagall',
				'Georgia O\'Keeffe',
				'Salvador Dalí',
				'Marsden Hartley',
				'Henri Matisse',
				'Wassily Kandinsky',
				'Lucian Freud',
				'Max Ernst',
				'Amedeo Modigliani',
				'Piet Mondrian',
				'Joan Miró',
				'Kazimir Malevich',
				'André Derain',
				'Albert Gleizes',
				'Frida Kahlo',
				'Paul Nash (artist)',
				'René Magritte',
				'Emily Carr',
				'John Nash (artist)',
				'Jörg Immendorff',
				'Fernand Léger',
				'Giacomo Balla',
				'Rufino Tamayo',
				'Jean Dubuffet',
				'Jean Metzinger',
				'Robert Rauschenberg',
				'Francis Bacon (artist)',
				'Ernst Ludwig Kirchner',
				'Pierre Bonnard',
				'Kuzma Petrov-Vodkin',
				'Juan O\'Gorman',
				'Fernando Botero',
				'Franz Marc',
				'James Ensor',
				'Stanisław Ignacy Witkiewicz',
				'Edward Hopper',
				'George Grosz',
				'Raoul Dufy',
				'George Bellows',
				'Thomas Hart Benton (painter)',
				'John Dos Passos',
				'Otto Dix',
				'Victor Vasarely',
				'Niki de Saint Phalle',
				'Franz Kline',
				'Julio González (sculptor)',
				'Amadeo de Souza Cardoso',
				'Maria Helena Vieira da Silva',
				'Barnett Newman',
				'Hans Hofmann',
				'Per Kirkeby',
				'Cy Twombly',
				'André Masson',
				'Francis Picabia',
				'Jean-Paul Riopelle',
				'Benito Quinquela Martín',
				'Theo van Doesburg',
			),
			'object-oriented programming languages' => array(
				'Java (programming language)',
				'C++',
				'PHP',
				'Python (programming language)',
				'Fortran',
				'Perl',
				'Ruby (programming language)',
				'COBOL',
				'Visual Basic',
				'Dart (programming language)',
				'Scala (programming language)',
				'Object Pascal',
				'Smalltalk',
				'Visual FoxPro',
				'Common Lisp',
				'SuperCollider',
				'Lua (programming language)',
				'OCaml',
				'FreeBASIC',
				'Gambas',
				'Objective-C',
				'Vala (programming language)',
				'Eiffel (programming language)',
				'Windows PowerShell',
				'Seed7',
				'D (programming language)',
				'Groovy (programming language)',
				'Processing (programming language)',
				'J (programming language)',
				'Self (programming language)',
				'Julia (programming language)',
				'Racket (programming language)',
				'Swift (programming language)',
				'Oxygene (programming language)',
				'E (programming language)',
				'Kotlin (programming language)',
				'Boo (programming language)',
				'Fantom (programming language)',
				'Squirrel (programming language)',
				'Cobra (programming language)',
				'Oberon-2 (programming language)',
				'Blitz BASIC',
				'Flavors (programming language)',
				'Lasso (programming language)',
				'BETA (programming language)',
				'Pike (programming language)',
				'Obix (programming language)',
				'JADE (programming language)',
				'Ateji PX',
				'Nemerle',
				'Emerald (programming language)',
				'Visual Prolog',
				'Chapel (programming language)',
				'ProvideX',
				'Allegro Common Lisp',
				'AgentSheets',
				'Bistro (programming language)',
				'Nu (programming language)',
				'Active Oberon',
				'ActiveVFP',
				'Actor (programming language)',
				'Adenine (programming language)',
				'Aldor',
				'Axum (programming language)',
				'Basic For Qt',
				'Cecil (programming language)',
				'Cel (programming language)',
				'Ciao (programming language)',
				'Claire (programming language)',
				'Clascal',
				'Class implementation file',
				'Compact Application Solution Language',
				'Converge (programming language)',
				'Cool (programming language)',
				'CorbaScript',
				'E Sharp (programming language)',
				'Easytrieve',
				'EusLisp Robot Programming Language',
				'Extensible ML',
				'F-Script (programming language)',
				'Falcon (programming language)',
				'Fancy (programming language)',
				'FPr (programming language)',
				'Free Pascal',
				'Game Oriented Assembly Lisp',
				'Gello Expression Language',
				'Genie (programming language)',
				'Goo (programming language)',
				'Gosu (programming language)',
				'Guido van Robot',
				'Ioke (programming language)',
				'Jasmin (software)',
				'Joule (programming language)',
				'JRuby',
				'Judoscript',
				'Jython',
				'Karel++',
				'Keykit',
				'Lagoona (programming language)',
				'Lightweight Java',
				'List of object-oriented programming languages',
				'Little b (programming language)',
				'Logtalk',
				'MacRuby',
				'MetaQuotes Language MQL4/MQL5',
				'MIMIC',
				'Mirah (programming language)',
				'Mixin',
				'Modula-3',
				'Monkey X',
				'Morfik FX',
				'Neko (programming language)',
				'NetRexx',
				'Newspeak (programming language)',
				'Noop',
				'NS Basic',
				'O:XML',
				'Oak (programming language)',
				'Oaklisp',
				'Object Lisp',
				'Object Oberon',
				'Object REXX',
				'Object-Oriented Turing',
				'Objective-J',
				'ObjectLOGO',
				'ObjVlisp',
				'ObjVProlog',
				'Oblog',
				'OMeta',
				'OpenEdge Advanced Business Language',
				'OptimJ',
				'OTcl',
				'Pauscal',
				'Pnuts',
				'Potion (programming language)',
				'Prograph',
				'Prolog++',
				'Python for S60',
				'QUILL',
				'ROOP (programming language)',
				'RubyMotion',
				'RUR-PLE',
				'S2 (programming language)',
				'SCOOP (software)',
				'Scriptol',
				'Simorgh Programming Language',
				'SMALL',
				'Smalltalk YX',
				'Span (programming language)',
				'Telescript (programming language)',
				'Tibbo BASIC',
				'Timber (programming language)',
				'TOM (object-oriented programming language)',
				'Turbo Pascal',
				'Turbo51',
				'Ubercode',
				'Umple',
				'Urbiscript',
				'Visual Basic',
			),
			'American TV dramas' => array(
				'Lost (TV series)',
				'The West Wing',
				'ER (TV series)',
				'Star Trek: The Next Generation',
				'CSI: Crime Scene Investigation',
				'NCIS (TV series)',
				'The X-Files',
				'Breaking Bad',
				'Star Trek: The Original Series',
				'Grey\'s Anatomy',
				'House (TV series)',
				'24 (TV series)',
				'Star Trek: Deep Space Nine',
				'Buffy the Vampire Slayer',
				'CSI: Miami',
				'Miami Vice',
				'Prison Break',
				'Law & Order',
				'Bones (TV series)',
				'True Blood',
				'Dawson\'s Creek',
				'Law & Order: Special Victims Unit',
				'CSI: NY',
				'Hannibal (TV series)',
				'Star Trek: Voyager',
				'Battlestar Galactica (2004 TV series)',
				'Twin Peaks',
				'Beverly Hills, 90210',
				'Once Upon a Time (TV series)',
				'Criminal Minds',
				'Touched by an Angel',
				'The Wire',
				'Fringe (TV series)',
				'The Mentalist',
				'All My Children',
				'The Americans (2013 TV series)',
				'NYPD Blue',
				'Baywatch',
				'Chicago Hope',
				'Big Love',
				'Chicago Fire (TV series)',
				'Quantum Leap',
				'The Walking Dead (TV series)',
				'Little House on the Prairie (TV series)',
				'JAG (TV series)',
				'The A-Team',
				'Gossip Girl',
				'Mission: Impossible',
				'Kojak',
				'One Life to Live',
				'Homicide: Life on the Street',
				'As the World Turns',
				'Hill Street Blues',
				'Without a Trace',
				'Medium (TV series)',
				'NCIS: Los Angeles',
				'Boardwalk Empire',
				'Burn Notice',
				'L.A. Law',
				'Boston Public',
				'Grimm (TV series)',
				'Hawaii Five-O',
				'Revenge (TV series)',
				'Ghost Whisperer',
				'Veronica Mars',
				'Walker, Texas Ranger',
				'Star Trek: Enterprise',
				'The Fugitive (TV series)',
				'Person of Interest (TV series)',
				'The Practice',
				'Kung Fu (TV series)',
				'The Waltons',
				'Elementary (TV series)',
				'Crossing Jordan',
				'90210 (TV series)',
				'Matlock (TV series)',
				'Nash Bridges',
				'Nashville (2012 TV series)',
				'Nip/Tuck',
				'Angel (1999 TV series)',
				'Ironside (1967 TV series)',
				'Cagney & Lacey',
				'Scandal (TV series)',
				'Starsky & Hutch',
				'Dirty Sexy Money',
				'Joan of Arcadia',
				'Everwood',
				'The Blacklist (TV series)',
				'Six Feet Under (TV series)',
				'Fantasy Island',
				'Adam-12',
				'Suits (TV series)',
				'Police Woman (TV series)',
				'Revolution (TV series)',
				'In the Heat of the Night (TV series)',
				'The Shield',
				'Eli Stone',
				'Private Practice (TV series)',
				'The L Word',
				'Jake and the Fatman',
				'21 Jump Street',
				'7th Heaven (TV series)',
				'Leverage (TV series)',
				'Cop Rock',
				'Zorro (1957 TV series)',
				'Friday Night Lights (TV series)',
				'Highway to Heaven',
				'Perry Mason (TV series)',
				'Homeland (TV series)',
				'NCIS: New Orleans',
				'Third Watch',
				'Empire (2015 TV series)',
				'Under the Dome (TV series)',
				'Party of Five',
				'Arrow (TV series)',
				'Scorpion (TV series)',
				'FlashForward',
				'New York Undercover',
				'Madam Secretary (TV series)',
				'White Collar (TV series)',
				'Life Goes On (TV series)',
				'24: Live Another Day',
				'Promised Land (TV series)',
				'Terra Nova (TV series)',
				'Army Wives',
				'The Closer',
				'Peter Gunn',
				'Rizzoli & Isles',
				'The Legend of Korra',
				'Gotham (TV series)',
				'Wiseguy',
				'American Playhouse',
				'Hell on Wheels (TV series)',
				'Justified (TV series)',
				'Nikita (TV series)',
				'Make It or Break It',
			),
		);
	}
}
