<template>
    <div
      class="mapa"
      ref="mapa"
    ></div>
</template>

<script>

  import GoogleMapsApiLoader from "google-maps-api-loader";

  export default {
    props: {
      apiKey: String,
      position: Object
    },

    data() {
      return {
        google: null,
        map: null,
        marker: null
      };
    },
    watch: {
        position: {
            deep: true,
            handler() {
              this.setPosition(parseFloat(this.position.lat), parseFloat(this.position.lng))
            }
        }
    },
    async mounted() {
      const googleMapApi = await GoogleMapsApiLoader({
        // Aqui abilito la liberia para autocompletar el buscador
        // libraries: ['places'],
        apiKey: this.apiKey
      });
      this.google = googleMapApi;
      this.initializeMap();
    },

    methods: {
      initializeMap() {
        const mapContainer = this.$refs.mapa
        var myLatlng = {}

        if (isNaN(this.position.lat)) {
          myLatlng = { lat: -34.6274353, lng: -58.5188871 }
        } else {
          myLatlng = { lat: parseFloat(this.position.lat), lng: parseFloat(this.position.lng) }
        }
        
        this.position.lat = myLatlng.lat
        this.position.lng = myLatlng.lng

        const map = this.map = new this.google.maps.Map(mapContainer, { 
          streetViewControl: false,
          zoom: 13,
          mapTypeId: 'terrain',
          mapTypeControlOptions: {
            mapTypeIds: ['satellite', 'terrain', 'roadmap', 'hybrid'],
          },
          center: myLatlng
        })

        const marker = this.marker = new google.maps.Marker({
          position: myLatlng,
          map,
          title: "Click to zoom",
        });

        map.addListener("click", (e) => {
          // map.setZoom(8);
          // map.setCenter({ lat: e.latLng.lat(), lng: e.latLng.lng() });
          this.position.lat = e.latLng.lat()
          this.position.lng = e.latLng.lng()
          this.setPosition(e.latLng.lat(), e.latLng.lng())
        })
      },
      setPosition(lat, lng) {
        this.marker.setPosition({ lat: lat, lng: lng })
      }
    }

  };
</script>

<style scoped>
  .mapa {
    width: 100%;
    height: 400px;
    /*min-height: 600px;
    margin-bottom: -100px;*/
  }
</style>
