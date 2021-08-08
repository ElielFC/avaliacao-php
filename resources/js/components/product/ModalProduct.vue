<template>
  <div
    class="modal fade"
    id="staticBackdrop"
    data-backdrop="static"
    data-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 v-if="id" class="modal-title" id="staticBackdropLabel">
            Atualizar Produto
          </h5>
          <h5 v-else class="modal-title" id="staticBackdropLabel">
            Novo Produto
          </h5>
          <button type="button" class="close" @click="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Nome*</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="product.product_name"
                  placeholder="Nome do Produto"
                />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Categoria do Produto*</label>
                <select
                  v-model="product.product_category_id"
                  class="form-control"
                >
                  <option value="">Selecione...</option>
                  <option
                    v-for="category in product_categories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Valor *</label>
                <money class="form-control" v-model="product.product_value" />
              </div>
            </div>
          </div>
          <p v-if="id" class="text-primary">
            Cadastrado em: {{ product.registration_date | format_date }}
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="close">
            Fechar
          </button>
          <button type="button" class="btn btn-primary" @click="onSave">Salvar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { format } from "date-fns";
export default {
  data() {
    return {
      id: null,
      resolve: null,
      reject: null,
      product: {
        product_category_id: "",
        product_name: "",
        product_value: "",
        registration_date: "",
      },
      product_categories: [],
    };
  },
  created() {
    this.getProductCategories();
  },
  methods: {
    open(id = null) {
      return new Promise((resolve, reject) => {
        this.resolve = resolve;
        this.reject = reject;
        this.id = id;
        if (id) {
          this.getProduct(id);
        }
        $(this.$el).modal({
          show: true,
        });
      });
    },
    onSave() {
      if (this.id) {
        this.updateProduct();
      } else {
        this.createProduct();
      }
    },
    async updateProduct() {
      await this.$axios.put(`/api/products/${this.id}`, this.product)
      .then(({data}) => {
        this.$swal.fire({
          text: "Produto atualizado com sucesso!",
          title: "Sucesso!",
          icon: "success",
        });
        this.resolve(data);
        this.close();
      })

    },
    async createProduct() {
      await this.$axios.post('/api/products', {
        ...this.product,
        registration_date: format(new Date(), "yyyy-MM-dd HH:mm:ss"),
      })
      .then(({data}) => {
        this.$swal.fire({
          text: "Produto criado com sucesso!",
          title: "Sucesso!",
          icon: "success",
        });
        this.resolve(data);
        this.close();
      })

    },
    async getProduct(id) {
      const { data } = await axios.get(`/api/products/${id}`);
      this.product = {
        product_category_id: data.product_category_id,
        product_name: data.product_name,
        product_value: data.product_value,
        registration_date: data.registration_date,
      };
    },
    async getProductCategories() {
      const { data } = await axios.get("/api/product-categories");
      this.product_categories = data.map(({ id, name }) => {
        return {
          id: id,
          name: name,
        };
      });
    },
    close() {
      this.clear();
      $(this.$el).modal("hide");
    },
    clear() {
      this.id = "";
      this.product = {
        product_category_id: "",
        product_name: "",
        product_value: "",
      };
      this.resolve = null;
      this.reject = null;
    },
  },
  filters: {
    format_date(value) {
      if (value) {
        return format(new Date(value.replace("-", "/")), "dd/MM/yyyy HH:mm");
      }
    },
  },
};
</script>
