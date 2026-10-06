const BREAKPOINT = '(min-width: 1024px)';

export default function initNavigation() {
	const header = document.querySelector( '.site-header' );
	const toggle = header?.querySelector( '.site-header__toggle' );
	const panel = header?.querySelector( '.site-header__panel' );

	if ( ! toggle || ! panel ) {
		return;
	}

	const desktop = window.matchMedia( BREAKPOINT );

	const setOpen = ( open ) => {
		toggle.setAttribute( 'aria-expanded', String( open ) );
		header.classList.toggle( 'is-open', open );
		document.documentElement.classList.toggle( 'nav-open', open );
	};

	const close = ( { restoreFocus = false } = {} ) => {
		setOpen( false );

		if ( restoreFocus ) {
			toggle.focus();
		}
	};

	toggle.addEventListener( 'click', () => {
		setOpen( toggle.getAttribute( 'aria-expanded' ) !== 'true' );
	} );

	panel.addEventListener( 'click', ( event ) => {
		if ( event.target.closest( 'a' ) ) {
			close();
		}
	} );

	document.addEventListener( 'keydown', ( event ) => {
		if (
			event.key === 'Escape' &&
			toggle.getAttribute( 'aria-expanded' ) === 'true'
		) {
			close( { restoreFocus: true } );
		}
	} );

	desktop.addEventListener( 'change', ( event ) => {
		if ( event.matches ) {
			close();
		}
	} );

	header.classList.add( 'is-ready' );
}
