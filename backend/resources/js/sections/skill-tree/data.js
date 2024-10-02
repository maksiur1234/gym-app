import { ref } from "vue";

export const data = ref({
    key: '0',
    type: 'cali',
    data: {
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwlq8CMoZMncZv0PBZ9SZr87NNPt3XsS196A&s',
        name: 'Kalistenika',
        title: 'Drzewo rozwoju'
    },
    children: [
        {
            key: '0_0',
            type: 'cali',
            data: {
                image: 'https://w7.pngwing.com/pngs/284/958/png-transparent-physical-fitness-front-lever-calisthenics-street-workout-silhouette-others-hand-logo-sticker-thumbnail.png',
                name: 'Push',
                title: 'Twój poziom push: 0'
            },
            children: [
                {
                    key: '0_0_0',
                    label: 'Pompki w oparciu o ścianę',
                    level: 0,
                    desc: 'Zrób to xygz..',
                    tutorial_url: 'https://www.youtube.com/embed/3h4fm29_Ag4',
                    children: [
                        {
                            key: '0_0_0_0',
                            label: 'Pompki na podwyższeniu',
                            level: 0,
                            desc: 'Zrób to xsssyz..',
                            children: [
                                {
                                    key: '0_0_0_0_0',
                                    label: 'Pompki klasyczne',
                                    level: 0,
                                    desc: 'Zrób to xyz..'
                                },
                            ],
                        },
                        {
                            key: '0_0_0_1',
                            label: 'Pompki na kolanach',
                            level: 0,
                            desc: 'Zrób to xyz..',
                        },
                    ],
                },
                {
                    key: '0_0_1',
                    label: 'Pompki z asystą gumy oporowej',
                    level: 0,
                    desc: 'Zrób to xyz..'
                }
            ],
        },
        {
            key: '0_1',
            type: 'cali',
            data: {
                image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4csEHcT3aVl8uc6jJNbZ5QJJoFrSes3TRDA&s',
                name: 'Pull',
                title: 'Twój poziom pull: 0'
            },
            children: [
                {
                    key: '0_1_0',
                    label: 'Podciąganie z gumą',
                    level: 0,
                    desc: 'Zrób to xyz..',
                    children: [
                        {
                            key: '0_1_0_0',
                            label: 'Podciąganie z pomocą nóg',
                            level: 0,
                            desc: 'Zrób to xyz..',
                        },
                        {
                            key: '0_1_0_1',
                            label: 'Podciąganie klasyczne',
                            level: 1,
                            desc: 'Zrób to xyz..',
                        }
                    ]
                },
                {
                    key: '0_1_1',
                    label: 'Podciąganie z pomocą nóg',
                    level: 0,
                    desc: 'Zrób to xyz..'
                }
            ]
        },
        {
            key: '0_2',
            type: 'cali',
            data: {
                image: 'https://image.spreadshirtmedia.net/image-server/v1/compositions/T6A1PA5835PT17X16Y62D144624866W27926H10973/views/1,width=550,height=550,appearanceId=1,backgroundColor=FFFFFF,noPt=true/full-planche-calisthenics-maenner-t-shirt.jpg',
                name: 'Legs',
                title: 'Poziom legs: 2'
            },
            children: [
                {
                    key: '0_2_0',
                    label: 'Przysiad z asystą',
                    level: 0,
                    desc: 'Zrób to xyz..',
                    children: [
                        {
                            key: '0_2_0_0',
                            label: 'Przysiad klasyczny',
                            level: 1,
                            desc: 'Zrób to xyz..',
                        },
                        {
                            key: '0_2_0_1',
                            label: 'Przysiad bułgarski',
                            level: 2,
                            desc: 'Zrób to xyz..',
                        }
                    ]
                },
            ]
        },
        {
            key: '0_3',
            type: 'cali',
            data: {
                image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-nGvDh4qnxORq5VMLWY309CBCPNScJgR98Q&s',
                name: 'Freestyle',
                title: 'Twój poziom freestyle: 0'
            },
            children: [
                {
                    key: '0_3_0',
                    label: 'Swing na drążku',
                    level: 0,
                    desc: 'Zrób to xyz..',
                    children: [
                        {
                            key: '0_3_0_0',
                            label: 'Human flag',
                            level: 3,
                            desc: 'Zrób to xyz..',
                        },
                        {
                            key: '0_3_0_1',
                            label: '360 na drążku',
                            level: 4,
                            desc: 'Zrób to xyz..',
                        }
                    ]
                },
            ]
        },
        {
            key: '0_4',
            type: 'cali',
            data: {
                image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-nGvDh4qnxORq5VMLWY309CBCPNScJgR98Q&s',
                name: 'Core',
                title: 'Twój poziom core: 0'
            },
            children: [
                {
                    key: '0_3_0',
                    label: 'Podpór na kolanach',
                    level: 0,
                    desc: 'Zrób to xyz..',
                    children: [
                        {
                            key: '0_3_0_0',
                            label: 'Podpór przodem',
                            level: 3,
                            desc: 'Zrób to xdfsyz..',
                        }
                    ]
                },
            ]
        }
    ]
});