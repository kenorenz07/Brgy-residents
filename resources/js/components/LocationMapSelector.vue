<template>
  <l-map
    ref="map"
    @dblclick="onMapClick"
    :zoom="zoom"
    :center="[
      household_location.lat || position.lat || userLocation.lat || defaultLocation.lat,
      household_location.lng || position.lng || userLocation.lng || defaultLocation.lng
    ]"
  >
    <l-tile-layer
      :url="tileProvider.url"
      :attribution="tileProvider.attribution"
    />
    <l-geosearch :options="geoSearchOptions"></l-geosearch>
    <l-marker
      v-if="position.lat && position.lng && marker_select"
      visible
      draggable
         :icon="geticon()" 
      :lat-lng.sync="position"
      @dragstart="dragging = true"
      @dragend="dragging = false"
    >
      <l-tooltip :content="tooltipContent"  />
    </l-marker>
    <l-marker v-for="marker in markers" :key="marker.id" :lat-lng="marker.location" :icon="getExistingIcon()" >
      <l-tooltip :content="marker.description" />
    </l-marker>
  </l-map>
</template>
<script>
import { LMap, LMarker, LTileLayer, LTooltip } from "vue2-leaflet";
import { OpenStreetMapProvider } from "leaflet-geosearch";
import LGeosearch from "vue2-leaflet-geosearch";
import { icon } from "leaflet";
export default {
  name: "LocationInput",
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LTooltip,
    LGeosearch
  },
  props: {
    value: {
      type: Object,
      required: true
    },
    defaultLocation: {
      type: Object,
      default: () => ({
        lat: 12.067878,
        lng: 124.595390
      })
    },
    household_location : {
      type: Object,
      default: () => ({
      })
    },
    household_id : {
      type: Number,
      default : null
    },
    marker_select : {
      type : Boolean,
      default : true
    },
    from_secretary : {
      type : Boolean,
      default : false
    }
  },
  data() {
    return {
      loading: false,
      geoSearchOptions: {
        provider: new OpenStreetMapProvider(),
        showMarker: false,
        autoClose: true
      },
      userLocation: {},
      icon: icon({
        iconRetinaUrl: require("leaflet/dist/images/marker-icon-2x.png"),
        iconUrl: require("leaflet/dist/images/marker-icon.png"),
        shadowUrl: require("leaflet/dist/images/marker-shadow.png")
      }),
      position: {},
      address: "",
      tileProvider: {
        attribution:
          '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
      },
      zoom: 18,
      dragging: false,
      markers: []
    };
  },
  mounted() {
    this.getUserPosition();
    this.$refs.map.mapObject.on("geosearch/showlocation", this.onSearch);
    setTimeout(() => {
        //mapObject is a property that is part of leaflet
        this.$refs.map.mapObject.invalidateSize(); 
    }, 100);
    this.getMarkers()
  },

  watch: {
    position: {
      deep: true,
      async handler(value) {
        this.address = await this.getAddress();
        this.$emit("input", { position: value, address: this.address });
      }
    },
    household_location : {
      immediate :true,
      deep :true,
      handler(value){
        this.position = this.household_location;

        this.getMarkers()
      }
    },
    household_id : {
      handler(value){
        this.position = this.household_location;

        this.getMarkers()
      }
    }
  },
  computed: {
    tooltipContent() {
      if (this.dragging) return "...";
      if (this.loading) return "Loading...";
      return `<strong>${this.address.replace(
        ",",
        "<br/>"
      )}</strong> <hr/><strong>lat:</strong> ${
        this.position.lat
      }<br/> <strong>lng:</strong> ${this.position.lng}`;
    }
  },
  methods: {
    setPositionMarkerLocation(){
      console.log('gege')
        this.position = this.household_location;

    },
    async getAddress() {
      this.loading = true;
      let address = "Unresolved address";
      try {
        const { lat, lng } = this.position;
        const result = await fetch(
          `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`
        );
        if (result.status === 200) {
          const body = await result.json();
          address = body.display_name;
        }
      } catch (e) {
        console.error("Reverse Geocode Error->", e);
      }
      this.loading = false;
      return address;
    },
    async onMapClick(value) {
      // place the marker on the clicked spot
      this.position = value.latlng;
    },
    onSearch(value) {
      const loc = value.location;
      this.position = { lat: loc.y, lng: loc.x };
    },
    geticon() {
          return L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            conSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    },
    getExistingIcon() {
          return L.icon({
            // iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
            
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            conSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    },
    getMarkers(){
      let params = {} 
      if(this.household_id && this.from_secretary == false)
        params.household_id = this.household_id

      if(localStorage.getItem('token')){
        this.$admin.get(`household/markers`,{params}).then(({data}) => {
          this.markers = data
        })
      }
    },
    async getUserPosition() {
      if (navigator.geolocation) {
        // get GPS position
        navigator.geolocation.getCurrentPosition(pos => {
          // set the user location
          this.userLocation = {
            lat: pos.coords.latitude,
            lng: pos.coords.longitude
          };
        });
      }
    }
  }
};
</script>