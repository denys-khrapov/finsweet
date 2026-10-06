const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		main: path.resolve( __dirname, 'src/js/main.js' ),
	},
	output: {
		...defaultConfig.output,
		path: path.resolve( __dirname, 'theme/assets/build' ),
	},
};
