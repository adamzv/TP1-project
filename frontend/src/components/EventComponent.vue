<template>

    <div style="padding-top: 30px;">

        <!-- Using Bulma column layout system -->
        <div class="columns is-desktop">

            <!-- Actual column iterated through the event list -->
            <div class="column grow" v-for="event in events" :key="event.id">

                <!-- Actual event panel/card -->
                <article class="panel _card">

                    <!--
                        Panel heading,
                        select a color scheme based on the faculty
                    -->
                    <div class="panel-heading"
                         v-bind:class="{
                            'eventBackColorFPV':(event.faculty == `FPV`),
                            'eventBackColorFF':(event.faculty == `FF`),
                            'eventBackColorFSS':(event.faculty == `FSS`)}">

                        <!-- Event name -->
                        <p class="alignLeft">
                            {{ event.name }}
                        </p>

                        <!-- Faculty name -->
                        <p class="alignRight" style="font-style: italic; font-size: 15px; padding-top: 5px;">
                            {{ event.faculty }}
                        </p>

                        <div style="clear: both;"></div>

                    </div>

                    <!-- Test image -->
                    <div class="panel-block" style="padding: 0;">
                        <img style="width: 100%;"
                             src="https://www.nitralive.sk/images/stories/vystavba/ukf/laboratoria/laboratoria-ukf-nitra-vizualizacia-titulka.jpg"
                             alt="alternatetext">
                    </div>

                    <!-- Quick details section -->
                    <div class="quickDetailsHeader"
                         v-bind:class="{
                            'eventDetailsHeaderColorFPV':(event.faculty == `FPV`),
                            'eventDetailsHeaderColorFF':(event.faculty == `FF`),
                            'eventDetailsHeaderColorFSS':(event.faculty == `FSS`)}">

                        <!-- Event date -->
                        <h1 class="alignLeft">
                            <strong>
                                {{ event.date }}
                            </strong>
                        </h1>

                        <!-- Event time -->
                        <h1 class="alignRight" style="font-style: italic;">
                            {{ event.time }}
                        </h1>

                        <br />

                        <!-- School department -->
                        <h1 class="alignLeft">
                            <strong style="color: #333333;">
                                {{ event.department }}
                            </strong>
                        </h1>

                        <!-- Place of the event -->
                        <h1 class="alignRight" style="font-style: italic;">
                            {{ event.place }}
                        </h1>

                        <div style="clear: both;"></div>
                    </div>

                    <!-- Details of the event -->
                    <div class="eventDetails">
                        <p>
                            {{ event.desc }}
                        </p>
                    </div>

                    <!-- Separator line -->
                    <hr style="margin: 0px;" />

                    <!-- Event links -->
                    <div class="eventLinks">
                        <div class="buttons">

                            <!-- Select a background color based off of the faculty -->
                            <div class="buttonSection" v-bind:class="{
                                'eventDetailsHeaderColorFPV':(event.faculty == `FPV`),
                                'eventDetailsHeaderColorFF':(event.faculty == `FF`),
                                'eventDetailsHeaderColorFSS':(event.faculty == `FSS`)}">

                                <!-- Actual buttons -->
                                <button class="button is-success">#ukf</button>
                                <button class="button is-warning">#fpv</button>
                                <button class="button is-danger">#ki</button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "EventComponent",

        // Test data (later the data will be fetched from the backend as .json objects)
        data() {
            return {
                events: [{
                    id: 0,
                    name: 'Karierny den',
                    desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod ' +
                        ' consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse',
                    date: '21. - 23.12.2020',
                    department: 'Katedra informatiky',
                    place: 'FPV Aula',
                    time: '12:30',
                    faculty: 'FPV'
                }, {
                    id: 1,
                    name: 'Taky den',
                    desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod ' +
                        'tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,' +
                        ' quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo' +
                        ' consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse',
                    date: '21. - 23.12.2020',
                    department: 'Katedra logisktiy',
                    place: 'FF Aula',
                    time: '14:30',
                    faculty: 'FF'
                }, {
                    id: 2,
                    name: 'Hentaky den',
                    desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod ' +
                        'tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,' +
                        ' quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
                    date: '21. - 23.12.2020',
                    department: 'Katedra blabla',
                    place: 'FSS Aula',
                    time: '10:32',
                    faculty: 'FSS'
                }]
            }
        },
    }
</script>

<style lang="scss" scoped>

    .grow { transition: all .14s ease-in-out; }
    .grow:hover { transform: scale(1.05);  cursor: pointer;}

    .alignLeft { float: left !important; }
    .alignRight { float: right !important; }

    .column {
        margin: 20px;

        .panel .panel-heading {
            color: white;
        }
    }

    .buttons {
        padding: 10px;
        margin: 0;
    }


    ._card {
        padding: 0px;
        margin: 10px;
        border-radius: 5px;
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

    .eventLinks {
        padding: 10px;

        .button {
            margin: 0;
            padding: 10px;
        }

        .buttonSection {
            padding: 5px;
            border-radius: 5px;
        }
    }

    .eventBackColorFPV { background: #55C8D9; }
    .eventBackColorFF { background: #FFC161; }
    .eventBackColorFSS { background: #26CB86; }

    .eventDetailsHeaderColorFPV { background: #D5F8FE; }
    .eventDetailsHeaderColorFF { background: #F8E3C4; }
    .eventDetailsHeaderColorFSS { background: #AADCC7; }

</style>