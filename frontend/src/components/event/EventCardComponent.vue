/*
*
* Created by: Martin Gajdos
* Date: 26. 10. 2020
*
* Description:  This component takes in all the event data coming from EventListComponent and renders
*               them in a card-like style.
*
*/

<template>

    <div class="column is-narrow card-container">

        <!-- Actual event card -->
        <article class="panel _card">

            <!-- Card heading -->
            <div class="panel-heading"
                 v-bind:class="{
                    'eventBackColorFPV':(eventFaculty == 'FPV'),
                    'eventBackColorFF':(eventFaculty == 'FF'),
                    'eventBackColorFSS':(eventFaculty == 'FSS')
                 }">

                <!-- Event name -->
                <p class="alignLeft">
                    {{ eventName }}
                </p>

                <!-- Faculty name -->
                <p class="alignRight" style="font-style: italic; font-size: 15px; padding-top: 5px;">
                    {{ eventFaculty }}
                </p>

                <div style="clear: both;"></div>

            </div>

            <!-- Test image -->
            <div class="panel-block" style="padding: 0;">
                <img style="width: 100%;"
                     src="https://www.nitralive.sk/images/stories/vystavba/ukf/laboratoria/laboratoria-ukf-nitra-vizualizacia-titulka.jpg"
                     alt="alternatetext">
            </div>

            <!-- Quick details about the event -->
            <div class="quickDetailsHeader"
                 v-bind:class="{
                    'eventDetailsHeaderColorFPV':(eventFaculty == 'FPV'),
                    'eventDetailsHeaderColorFF':(eventFaculty == 'FF'),
                    'eventDetailsHeaderColorFSS':(eventFaculty == 'FSS')
                 }">

                <!-- Event date -->
                <h1 class="alignLeft">
                    <strong>
                        {{ eventDate }}
                    </strong>
                </h1>

                <!-- Event time -->
                <h1 class="alignRight" style="font-style: italic;">
                    {{ eventTime }}
                </h1>

                <br />

                <!-- School department -->
                <h1 class="alignLeft">
                    <strong>
                        {{ eventDepartment }}
                    </strong>
                </h1>

                <!-- Place of the event -->
                <h1 class="alignRight" style="font-style: italic;">
                    {{ eventPlace }}
                </h1>

                <div style="clear: both;"></div>
            </div>

            <!-- Details of the event -->
            <div class="eventDetails">
                <p>
                    {{ eventDesc }}
                </p>
            </div>

            <!-- Separator line -->
            <hr style="margin: 0px;" />

            <!-- Event tags -->
            <div class="eventTags">
                <div class="tagsSection">

                    <!-- Select a background color based off of the faculty -->
                    <div class="tags" v-bind:class="{
                       'eventDetailsHeaderColorFPV':(eventFaculty == 'FPV'),
                        'eventDetailsHeaderColorFF':(eventFaculty == 'FF'),
                        'eventDetailsHeaderColorFSS':(eventFaculty == 'FSS')
                    }">

                        <!-- Actual tags -->
                        <b-button rounded size="is-small" v-for="tag in eventTags" :key="tag.id">
                            #{{ tag.value }}
                        </b-button>
                    </div>
                </div>
            </div>
        </article>
    </div>

</template>

<script>
    export default {
        name: "EventCardComponent",

        data() {
            return {
                clicked: false
            }
        },

        // Props that this component is expecting to be passed from EventListComponent
        props: {
            eventId: {
                type: Number,
                required: true
            },
            eventName: {
                type: String,
                required: true
            },
            eventDesc: {
                type: String,
                required: true
            },
            eventDate: {
                type: String,
                required: true
            },
            eventTime: {
                type: String,
                required: true
            },
            eventPlace: {
                type: String,
                required: true
            },
            eventFaculty: {
                type: String,
                required: true
            },
            eventDepartment: {
                type: String,
                required: true
            },
            eventTags: {
                type: Array,
                required: true
            }
        }
    }
</script>

<style lang="scss" scoped>

    .card-container {
        max-width: 500px;
    }

    .alignLeft { float: left !important; }
    .alignRight { float: right !important; }

    .column {
        margin: 20px;

        .panel .panel-heading {
            color: white;
        }
    }

    .tagsSection {
        padding: 10px;
        margin: 0;
        width: max-content;
    }


    ._card {
        padding: 0px;
        margin: 10px;
        border-radius: 10px;
        -webkit-box-shadow: 0px 18px 42px -17px rgba(0,0,0,0.74);
        -moz-box-shadow: 0px 18px 42px -17px rgba(0,0,0,0.74);
        box-shadow: 0px 18px 42px -17px rgba(0,0,0,0.74);
    }

    .quickDetailsHeader { padding: 7px 20px 7px 20px; }

    .eventDetails {
        padding: 20px;
        text-align: justify;
        height: 200px;
        max-height: 200px;
    }

    .eventTags {
        padding: 10px;

        .button {
            margin-right: 5px;
            padding: 10px;
            opacity: 0.9;
        }

        .tags {
            padding: 5px;
            border-radius: 20px;
            margin: 0px;

        }
    }

    .eventBackColorFPV { background: #55C8D9; }
    .eventBackColorFF { background: #FFC161; }
    .eventBackColorFSS { background: #26CB86; }

    .eventDetailsHeaderColorFPV { background: #D5F8FE; }
    .eventDetailsHeaderColorFF { background: #F8E3C4; }
    .eventDetailsHeaderColorFSS { background: #AADCC7; }

    .panel { transition: all .14s ease-in-out; }
    .panel:hover { transform: scale(1.05);  cursor: pointer;}

    /* Media queries */
    @media only screen and (max-width: 1072px) {
        .card-container {
            max-width: fit-content;
            width: auto;
        }
    }

</style>