<template>
  <div class="card">
    <div class="card-header">Categorias de Produtos</div>
    <div class="card-body">
      <div class="row justify-content-end">
        <div class="col-md-12">
          <button
            @click="newProduct"
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
          Lista de Produtos
        </caption>
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Categoria</th>
            <th scope="col">Data de Registro</th>
            <th scope="col">Preço</th>
            <th scope="col" class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>{{ product.id }}</td>
            <td>{{ product.product_name }}</td>
            <td>{{ product.product_category_name }}</td>
            <td>{{ product.registration_date | format_date }}</td>
            <td>{{ product.product_value | format_money }}</td>
            <td class="text-center">
              <div class="btn-group btn-group-sm" role="group">
                <button
                  type="button"
                  @click="onEditProduct(product)"
                  class="btn btn-outline-primary"
                >
                  Editar
                </button>
                <button
                  type="button"
                  @click="onDeleteProduct(product)"
                  class="btn btn-outline-danger"
                >
                  Excluir
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <modal-product ref="modalProduct"/>
  </div>
</template>

<script>
import { format } from "date-fns";
import ModalProduct from "./ModalProduct";
export default {
  components: {
    ModalProduct
  },
  data() {
    return {
      products: [],
    };
  },
  created() {
    this.getProducts();
  },
  methods: {
    newProduct() {
      this.$refs.modalProduct.open().then(() => {
        this.getProducts();
      });
    },
    onEditProduct(product) {
      this.$refs.modalProduct.open(product.id).then(() => {
        this.getProducts();
      });
    },
    getProducts() {
      this.$axios.get("/api/products").then(({ data }) => {
        this.products = data;
      });
    },
    onDeleteProduct(product) {
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
          this.$axios.delete(`/api/products/${product.id}`).then(() => {
            this.$swal.fire("Excluído!", "O produto foi excluído.", "success");
            this.getProducts();
          });
        }
      });
    },
  },
  filters: {
    format_money(value) {
      let money = new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      });
      return money.format(value);
    },
    format_date(value) {
      return format(new Date(value.replace("-", "/")), "dd/MM/yyyy HH:mm");
    },
  },
};
</script>
