<template>
  <div class="card">
    <div class="card-header">Categorias de Produtos</div>
    <div class="card-body">
      <div class="row justify-content-end">
        <div class="col-md-12">
          <button
            @click="newProductCategory"
            type="button"
            class="btn btn-outline-primary"
          >
            Novo
          </button>
        </div>
      </div>
      <br />
      <table class="table">
        <caption>
          Lista de Categorias de Produtos
        </caption>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col" class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in product_categories" :key="item.id">
            <th scope="row">{{ item.id }}</th>
            <td>
              <a
                href="#"
                @click.prevent="onEditProductCategory(item)"
                class="btn btn-link btn-sm"
                >{{ item.name }}</a
              >
            </td>
            <td class="text-center">
              <button
                v-if="!item.associated_with_products"
                type="button"
                @click.prevent="onDestroyProductCategory(item)"
                class="btn btn-outline-danger btn-sm"
              >
                Excluir
              </button>
              <button v-else disabled="true" class="btn btn-outline-danger btn-sm" title="Não é possível excluir categorias que já estão associada em produtos.">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <modal-product-category ref="productCategory" />
  </div>
</template>

<script>
import ModalProductCategory from "./ModalProductCategory.vue";
export default {
  components: {
    ModalProductCategory,
  },
  data() {
    return {
      product_categories: [],
    };
  },
  mounted() {
    this.getProductCategories();
  },
  methods: {
    getProductCategories() {
      this.$axios
        .get("/api/product-categories")
        .then(({ data: product_categories }) => {
          this.product_categories = product_categories;
        });
    },
    newProductCategory() {
      this.$refs.productCategory
        .open()
        .then((data) => {
          this.product_categories.push(data);
        })
        .catch(() => {
          this.getProductCategories();
        });
    },
    onEditProductCategory(product_category) {
      this.$refs.productCategory
        .open(product_category.id)
        .then((data) => {
          product_category.name = data.name;
        })
        .catch(() => {
          this.getProductCategories();
        });
    },
    onDestroyProductCategory(product_category) {
      this.$swal.fire({
        title: "Você tem certeza?",
        text: "Esse processo é irreversível!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, Excluir este!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$axios
            .delete(`/api/product-categories/${product_category.id}`)
            .then(() => {
              this.$swal.fire("Excluído!", "A categoria de produto foi excluído.", "success");
              this.getProductCategories();
            });
        }
      });
    },
  },
};
</script>
