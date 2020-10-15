<template>
  <div
    :class="{
      'c-filters': true,
    }"
  >
    <div v-if="show" class="c-filters__content">
      <div class="c-filters__name">
        <label>
          Name:
          <input v-model="characterName" type="text" />
        </label>
      </div>
      <Autocomplete
        name="Comics"
        :value="comicIds"
        :loading="fetchingComics"
        :options="comicOptions"
        :init-label="initLabel"
        :disabled="fetchingInitLabel"
        @change="searchComics"
        @remove="removeComicId"
        @select="updateComicId"
      />
    </div>
    <div class="c-filters__toggle">
      <button class="button button-clear" @click="toggleShow">
        {{ show ? 'Hide filters' : 'Show filters' }}
      </button>
    </div>
  </div>
</template>

<script>
import Autocomplete from '~/components/Autocomplete';

export default {
  name: 'Filters',
  components: {
    Autocomplete,
  },
  data() {
    let comicIds = [];
    if (this.$route.query['comic-id']) {
      comicIds = this.$route.query['comic-id'].map((val) => {
        return {
          value: val,
          label: 'loading...',
        };
      });
    }

    return {
      characterName: this.$route.query['character-name']
        ? this.$route.query['character-name']
        : '',
      nameTimeout: null,
      comicIds,
      comicOptions: [],
      fetchingComics: false,
      initLabel: '',
      show: true,
    };
  },
  computed: {
    filterObject() {
      const query = {};

      if (this.characterName) {
        query['character-name'] = this.characterName;
      }

      if (this.comicIds) {
        query['comic-id'] = this.comicIds.map((val) => val.value);
      }

      return query;
    },
  },
  watch: {
    characterName() {
      clearTimeout(this.nameTimeout);
      this.nameTimeout = setTimeout(this.updateQuery, 1000);
    },
  },
  created() {
    for (const comic of this.comicIds) {
      this.fetchComicLabel(comic.value);
    }
  },
  methods: {
    async fetchComicLabel(comicId) {
      const params = {
        apikey: this.$store.state.apiKey,
      };

      try {
        this.fetchingComics = true;
        const response = await this.$axios({
          method: 'GET',
          url: 'https://gateway.marvel.com:443/v1/public/comics/' + comicId,
          params,
        });

        if (!response.data.data.results[0]) {
          throw new Error('Comic not found');
        }

        const label = response.data.data.results[0].title;
        this.comicIds.map((comic) => {
          if (comic.value === comicId) {
            comic.label = label;
          }
        });
      } catch (error) {
        console.error(error);
        this.comicId = null;
        this.updateQuery();
      }
    },
    toggleShow() {
      this.show = !this.show;
    },
    updateQuery() {
      console.log(this.filterObject);
      const newQuery = this.filterObject;

      this.$router.push({
        path: '/marvel/characters/1',
        query: newQuery,
      });
    },
    async searchComics(comicTitle) {
      if (comicTitle.length === 0) {
        return;
      }

      const params = {
        apikey: this.$store.state.apiKey,
        limit: 10,
        titleStartsWith: comicTitle,
      };

      try {
        this.fetchingComics = true;
        const response = await this.$axios({
          method: 'GET',
          url: 'https://gateway.marvel.com:443/v1/public/comics',
          params,
        });

        this.comicOptions = response.data.data.results.map(function (comic) {
          return {
            value: comic.id,
            label: comic.title,
          };
        });
      } catch (error) {
        console.error(error);
      }
      this.fetchingComics = false;
    },
    updateComicId(comic) {
      if (comic !== null) {
        this.comicIds.push(comic);
      }
      this.comicOptions = [];
      this.updateQuery();
    },
    removeComicId(comicId) {
      const index = this.comicIds.reduce((index, comic, curIndex) => {
        if (comic.value === comicId) {
          return curIndex;
        }

        return index;
      }, -1);

      if (index === -1) {
        return;
      }

      this.comicIds.splice(index, 1);
      this.updateQuery();
    },
  },
};
</script>

<style lang="scss">
.c-filters {
  padding: 1rem;
  border: 1px solid purple;
  &__toggle {
    text-align: center;
    button {
      margin-bottom: 0;
    }
  }
}
</style>
