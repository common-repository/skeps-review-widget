// Require path.
const path = require( 'path' );
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");

// Configuration object.
const config = {
	// Create the entry points.
	// One for frontend and one for the admin area.
	entry: {
		// frontend and admin will replace the [name] portion of the output config below.
		public: ['./src/js/public.js', './src/scss/public.scss'],
		admin: ['./src/js/admin.js','./src/scss/admin.scss']
	},

	// Create the output files.
	// One for each of our entry points.
	output: {
		// [name] allows for the entry object keys to be used as file names.
		filename: 'js/sgr-[name].js',
		// Specify the path to the JS files.
		path: path.resolve( __dirname, 'dist/assets' )
	},

	externals: {
		jquery: 'jQuery',
		owlCarousel: 'owlCarousel'
	},

	// Setup a loader to transpile down the latest and great JavaScript so older browsers
	// can understand it.
	module: {
		rules: [
			{
				// Look for any .js files.
				test: /\.js$/,
				// Exclude the node_modules folder.
				exclude: /node_modules/,
				// Use babel loader to transpile the JS files.
				loader: 'babel-loader'
			},
			{
				test: /\.(sass|scss)$/,
				use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
			}, 
			{
				test: /\.css$/,
				use: [
				  'vue-style-loader',
				  'css-loader'
				]
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader'
			}
		]
	},
	
	plugins: [
		// extract css into dedicated file
		new MiniCssExtractPlugin({
		  filename: 'css/sgr-[name].min.css',
		}),
		new VueLoaderPlugin()
	],

	optimization: {
		minimizer: [
		  // enable the js minification plugin
		  new UglifyJSPlugin({
			cache: true,
			parallel: true
		  }),
		  // enable the css minification plugin
		  new OptimizeCSSAssetsPlugin({})
		]
	  }

}

// Export the config object.
module.exports = config;