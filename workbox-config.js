module.exports = {
	globDirectory: '.',
	globPatterns: [
		'**/*.{css,png,json,js,html}'
	],
	swDest: 'sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};