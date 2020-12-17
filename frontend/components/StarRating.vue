<template>
  <svg xmlns="http://www.w3.org/2000/svg" width="150px" height="24">
    <path
      v-for="(star, index) in stars"
      :key="index"
      :style="{
        transform: `translate(${index * 28}px, 0)`,
        fill: star.fill,
      }"
      d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"
    />
  </svg>
</template>

<script>
export default {
  name: 'Star',
  props: {
    rating: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      stars: [
        { fill: 'white' },
        { fill: 'white' },
        { fill: 'white' },
        { fill: 'white' },
        { fill: 'white' },
      ],
    };
  },
  watch: {
    rating(val) {
      this.fillLower(val);
    },
  },
  mounted() {
    this.fillLower(this.rating);
  },
  methods: {
    fillLower(index) {
      this.stars = this.stars.map((star, i) => {
        if (i < index) {
          star.fill = 'goldenrod';
        } else star.fill = 'white';
        return star;
      });
    },
  },
};
</script>

<style scoped>
path {
  stroke-width: 2px;
  fill: white;
  stroke: black;
}
</style>
