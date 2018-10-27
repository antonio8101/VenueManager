<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        <a href="/logout">Logout</a>
                    </div>

                    <div class="card-header">
                        Title
                    </div>

                    <div class="card-body">
                        Component content
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
