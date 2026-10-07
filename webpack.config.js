const fs = require( 'fs' );
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const blocksDir = path.resolve( __dirname, 'theme/blocks' );

/**
 * Every theme/blocks/<name>/style.scss becomes its own entry,
 * built to theme/assets/build/blocks/<name>.css.
 */
const blockEntries = fs.existsSync( blocksDir )
	? fs
			.readdirSync( blocksDir, { withFileTypes: true } )
			.filter(
				( dir ) =>
					dir.isDirectory() &&
					fs.existsSync(
						path.join( blocksDir, dir.name, 'style.scss' )
					)
			)
			.reduce( ( entries, dir ) => {
				entries[ `blocks/${ dir.name }` ] = path.join(
					blocksDir,
					dir.name,
					'style.scss'
				);
				return entries;
			}, {} )
	: {};

/**
 * Every theme/blocks/<name>/view.js becomes its own entry,
 * built to theme/assets/build/blocks/view-<name>.js.
 */
const viewEntries = fs.existsSync( blocksDir )
	? fs
			.readdirSync( blocksDir, { withFileTypes: true } )
			.filter(
				( dir ) =>
					dir.isDirectory() &&
					fs.existsSync( path.join( blocksDir, dir.name, 'view.js' ) )
			)
			.reduce( ( entries, dir ) => {
				entries[ `blocks/view-${ dir.name }` ] = path.join(
					blocksDir,
					dir.name,
					'view.js'
				);
				return entries;
			}, {} )
	: {};

module.exports = {
	...defaultConfig,
	entry: {
		main: path.resolve( __dirname, 'src/js/main.js' ),
		...blockEntries,
		...viewEntries,
	},
	output: {
		...defaultConfig.output,
		path: path.resolve( __dirname, 'theme/assets/build' ),
	},
};
