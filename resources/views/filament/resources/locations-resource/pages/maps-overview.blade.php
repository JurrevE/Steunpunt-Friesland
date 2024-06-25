<x-filament-panels::page>
    <x-filament::fieldset>
        <x-slot name="label">
            Address
        </x-slot>
        
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        
        <div id="controls">
            <div>
                Address: <input type="text" id="address">
                <button onclick="geocodeAddress()">Go</button>
            </div>
            <div>
                Radius (km): <input type="number" id="radius" value="5">
                <button onclick="updateRadius()">Update Radius</button>
            </div>
        </div>
        
        <div id="map"></div>
    </x-filament::fieldset>

    <!-- Include Leaflet library -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Include your custom JavaScript file -->
    <script src="{{ asset('js/filament/radius.js') }}"></script>

    <style>
        #map {
            height: 80vh;
            width: 100%;
        }

        #controls {
            margin-bottom: 10px;
        }
    </style>
</x-filament-panels::page>
