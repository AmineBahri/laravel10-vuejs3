<script setup>
import { ref } from '@vue/reactivity';
const ex11 = ref(['red', 'indigo', 'orange', 'primary', 'secondary', 'success', 'info', 'warning', 'error', 'red-darken-3', 'indigo-darken-3', 'orange-darken-3']);
</script>
<template>
    <div>
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <v-card flat>
                <v-card-text>
                <v-container fluid>
                    <v-row>
                    <v-col
                        cols="12"
                        md="4"
                        sm="4"
                    >
                        <v-switch
                        v-model="ex11"
                        color="red"
                        label="red"
                        value="red"
                        hide-details
                        ></v-switch>
                        <v-switch
                        v-model="ex11"
                        color="red-darken-3"
                        label="red-darken-3"
                        value="red-darken-3"
                        hide-details
                        ></v-switch>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                        sm="4"
                    >
                        <v-switch
                        v-model="ex11"
                        color="indigo"
                        label="indigo"
                        value="indigo"
                        hide-details
                        ></v-switch>
                        <v-switch
                        v-model="ex11"
                        color="indigo-darken-3"
                        label="indigo-darken-3"
                        value="indigo-darken-3"
                        hide-details
                        ></v-switch>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                        sm="4"
                    >
                        <v-switch
                        v-model="ex11"
                        color="orange"
                        label="orange"
                        value="orange"
                        hide-details
                        ></v-switch>
                        <v-switch
                        v-model="ex11"
                        color="orange-darken-3"
                        label="orange-darken-3"
                        value="orange-darken-3"
                        hide-details
                        ></v-switch>
                    </v-col>
                    </v-row>

                    <v-row class="mt-12">
                    <v-col
                        cols="12"
                        md="4"
                        sm="4"
                    >
                        <v-switch
                        v-model="ex11"
                        color="primary"
                        label="primary"
                        value="primary"
                        hide-details
                        ></v-switch>
                        <v-switch
                        v-model="ex11"
                        color="secondary"
                        label="secondary"
                        value="secondary"
                        hide-details
                        ></v-switch>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                        sm="4"
                    >
                        <v-switch
                        v-model="ex11"
                        color="success"
                        label="success"
                        value="success"
                        hide-details
                        ></v-switch>
                        <v-switch
                        v-model="ex11"
                        color="info"
                        label="info"
                        value="info"
                        hide-details
                        ></v-switch>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                        sm="4"
                    >
                        <v-switch
                        v-model="ex11"
                        color="warning"
                        label="warning"
                        value="warning"
                        hide-details
                        ></v-switch>
                        <v-switch
                        v-model="ex11"
                        color="error"
                        label="error"
                        value="error"
                        hide-details
                        ></v-switch>
                    </v-col>
                    </v-row>
                </v-container>
                </v-card-text>
            </v-card>
            <v-btn
                class="ma-2"
                color="primary"
            >
                Accept
                <v-icon
                icon="mdi-checkbox-marked-circle"
                end
                ></v-icon>
            </v-btn>
            <div>
                <v-btn
                    class="ma-2"
                    color="blue-lighten-2"
                    icon="mdi-thumb-up"
                    variant="text"
                ></v-btn>

                <v-btn
                    class="ma-2"
                    color="red-lighten-2"
                    icon="mdi-thumb-down"
                    variant="text"
                ></v-btn>
            </div>
        </div>

        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Earnings (Monthly)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Earnings (Annual)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Requests</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6">

                <!-- Default Card Example -->
                <div class="card mb-4">
                    <div class="card-header">
                        Default Card Example
                    </div>
                    <div class="card-body">
                        This card uses Bootstrap's default styling with no utility classes added. Global
                        styles are the only things modifying the look and feel of this default card example.
                    </div>
                </div>

                <!-- Basic Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Basic Card Example</h6>
                    </div>
                    <div class="card-body">
                        The styling for this basic card example is created by using default Bootstrap
                        utility classes. By using utility classes, the style of the card component can be
                        easily modified with no need for any custom CSS!
                    </div>
                </div>

            </div>

            <div class="col-lg-6">

                <!-- Dropdown Card Example -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Dropdown Card Example</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        Dropdown menus can be placed in the card header in order to extend the functionality
                        of a basic card. In this dropdown card example, the Font Awesome vertical ellipsis
                        icon in the card header can be clicked on in order to toggle a dropdown menu.
                    </div>
                </div>

                <!-- Collapsable Card Example -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Collapsable Card Example</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            This is a collapsable card example using Bootstrap's built in collapse
                            functionality. <strong>Click on the card header</strong> to see the card body
                            collapse and expand!
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</template>
