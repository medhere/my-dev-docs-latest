
React/Svelte and capacitor
	npm install @capacitor/core @capacitor/android @capacitor/ios @capacitor-community/electron

	cap init [name] [com.name.name] --web-dir=build
	
	npm run build

		to install plugins
		npm install @capacitor/app
		cap sync

	cap add android
	cap add ios
	cap add @capacitor-community/electron

	cap run android
	cap run ios
	cap open @capacitor-community/electron
