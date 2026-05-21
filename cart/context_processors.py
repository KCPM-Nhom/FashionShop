from .cart import Cart

#create context_proc -> cart can work on all sites
def cart(request):
    #return default data from cart
    return {'cart':Cart(request)}