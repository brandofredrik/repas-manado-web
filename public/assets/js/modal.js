/**
 *  Delete Function
 *
 */

var base_url = window.location.origin;
var folder = '';

function deleteData(id, route) {
    let container = document.querySelector('#deleteModalContainer')
    let strAvailableData = `
        <a
            href="`+base_url+folder+`/dashboard/`+route+`/`+id+`/delete"
            class="btn btn-danger"
        >
            Delete
        </a>
    `
    return container.innerHTML = strAvailableData
}

/**
 *  Show Market Function
 *
 */


$('#editMarket').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var market = button.data('market')
    var modal = $(this)
    getMarketDetail(market, modal)
})

async function getMarketDetail(id, modal) {
    try {
        var apiUri = base_url + folder + '/dashboard/markets/'+id+'/show'
        const apiUrl = await(fetch(apiUri))
        const market = await apiUrl.json()
        showMarketDetail(market, modal)
    }
    catch(err) { console.log(err); }
}

function showMarketDetail(market, modal) {
    modal.find('.modal-title').text('Edit ' +market.title)
    modal.find('.modal-body #id').val(market.id)
    modal.find('.modal-body #title').val(market.title)
    modal.find('.modal-body #address').val(market.address)
    modal.find('.modal-body #latitude').val(market.lat)
    modal.find('.modal-body #longitude').val(market.lng)
}

/**
 *  Show Building Type Function
 *
 */

$('#editType').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var market = button.data('buildingtype')
    var modal = $(this)
    getTypeDetail(market, modal)
})

async function getTypeDetail(id, modal) {
    try {
        var apiUri = base_url + folder + '/dashboard/buildings/types/'+id+'/show'
        const apiUrl = await(fetch(apiUri))
        const type = await apiUrl.json()
        showTypeDetail(type, modal)
    }
    catch(err) { console.log(err); }
}

function showTypeDetail(type, modal) {
    modal.find('.modal-title').text('Edit ' +type.title)
    modal.find('.modal-body #id').val(type.id)
    modal.find('.modal-body #title').val(type.title)
    modal.find('.modal-body #description').val(type.description)
}

/**
 *  Show Building Type Function
 *
 */

$('#editPrice').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var market = button.data('buildingprice')
    var modal = $(this)
    getPriceDetail(market, modal)
})

async function getPriceDetail(id, modal) {
    try {
        var apiUri = base_url + folder + '/dashboard/buildings/prices/'+id+'/show'
        const apiUrl = await(fetch(apiUri))
        const price = await apiUrl.json()
        showPriceDetail(price, modal)
    }
    catch(err) { console.log(err); }
}

function showPriceDetail(price, modal) {
    modal.find('.modal-title').text('Edit ' +price.title)
    modal.find('.modal-body #id').val(price.id)
    modal.find('.modal-body #title').val(price.title)
    modal.find('.modal-body #description').val(price.description)
    modal.find('.modal-body #price').val(price.price)
    modal.find('.modal-body #type_id').val(price.type_id)
}

/**
 *  Show Owner Type Function
 *
 */

$('#editOwner').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var owner = button.data('owner')
    var modal = $(this)
    getOwnerDetail(owner, modal)
})

async function getOwnerDetail(id, modal) {
    try {
        var apiUri = base_url + folder + '/dashboard/merchant/owners/'+id+'/show'
        const apiUrl = await(fetch(apiUri))
        const owner = await apiUrl.json()
        showOwnerDetail(owner, modal)
    }
    catch(err) { console.log(err); }
}

function showOwnerDetail(owner, modal) {
    modal.find('.modal-title').text('Edit - ' +owner.name)
    modal.find('.modal-body #id').val(owner.id)
    modal.find('.modal-body #name').val(owner.name)
    modal.find('.modal-body #phone').val(owner.phone)
    modal.find('.modal-body #identity_type').val(owner.identity_type)
    modal.find('.modal-body #identity_number').val(owner.identity_number)
}

/**
 *  Show Building Type Function
 *
 */

$('#editBuilding').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var building = button.data('building')
    var modal = $(this)
    getBuildingDetail(building, modal)
})

async function getBuildingDetail(id, modal) {
    try {
        var apiUri = base_url + folder + '/dashboard/merchant/buildings/'+id+'/show'
        const apiUrl = await(fetch(apiUri))
        const building = await apiUrl.json()
        showBuildingDetail(building, modal)
    }
    catch(err) { console.log(err); }
}

function showBuildingDetail(building, modal) {
    modal.find('.modal-title').text('Edit - ' +building.name)
    modal.find('.modal-body #id').val(building.id)
    modal.find('.modal-body #register_number').val(building.register_number)
    modal.find('.modal-body #owner_id').val(building.owner[0].id)
    modal.find('.modal-body #name').val(building.name)
    modal.find('.modal-body #description').val(building.description)
    modal.find('.modal-body #widht').val(building.widht)
    modal.find('.modal-body #length').val(building.length)
    modal.find('.modal-body #market_id').val(building.market_id)
    modal.find('.modal-body #price_id').val(building.price_id)
}