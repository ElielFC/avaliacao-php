<template>
  <div class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 v-if="id" class="modal-title">Atualizar Categoria de Produto</h5>
          <h5 v-else class="modal-title">Nova Categoria de Produto</h5>
          <button type="button" class="close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nome:</label>
            <input type="text" class="form-control" v-model="item.name" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="close">
            Sair
          </button>
          <button type="button" class="btn btn-primary" @click="onSave()">
            Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: "",
      item: {
        name: "",
      },
      resolve: null,
      reject: null,
    };
  },
  methods: {
    open(id = null) {
      return new Promise((resolve, reject) => {
        this.resolve = resolve;
        this.reject = reject;
        this.id = id;
        if (id) {
          this.getItem(id);
        }
        $(this.$el).modal({
          show: true,
        });
      });
    },
    async getItem(id) {
      const { data } = await axios.get(`/api/product-categories/${id}`);
      this.item = data;
    },
    onSave() {
      if (this.id) {
        this.updateItem();
      } else {
        this.createItem();
      }
    },
    async createItem() {
      await axios
        .post(`/api/product-categories`, {
          name_category: this.item.name,
        })
        .then(({ data }) => {
          this.$swal.fire({
            text: "Categoria de Produto criada com sucesso!",
            title: "Sucesso!",
            icon: "success",
          });
          this.resolve(data);
          this.close();
        })
    },
    async updateItem() {
      await axios
        .put(`/api/product-categories/${this.id}`, {
          name_category: this.item.name,
        })
        .then(({ data }) => {
          this.$swal.fire({
            text: "Categoria de Produto alterada com sucesso!",
            title: "Sucesso!",
            icon: "success",
          });
          this.resolve(data);
          this.close();
        })
    },
    close() {
      this.clear();
      $(this.$el).modal("hide");
    },
    clear() {
      this.id = "";
      this.item = {
        name: "",
      };
      this.resolve = null;
      this.reject = null;
    },
  },
};
</script>
