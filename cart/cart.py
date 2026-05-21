from store.models import Product, Profile

class Cart():
    def __init__(self, request):
        self.session = request.session
        #get request
        self.request = request
        
        #get session key if exist
        cart = self.session.get('session_key')
        
        #if user is new -> no session key -> create one
        
        if 'session_key' not in request.session:
            cart = self.session['session_key'] = {}
        #make cart available on all site pages
        self.cart = cart
    
    def db_add(self, product, quantity):
        product_id = str(product)
        product_qty = str(quantity)
        
        #logic 
        if product_id in self.cart:
            pass
        else:
            #self.cart[product_id] = {'price': str(product.price)}
            self.cart[product_id] = int(product_qty)
        self.session.modified = True
        
        #duel with login in user
        if self.request.user.is_authenticated:
            #get the current user profile
            current_user = Profile.objects.filter(user__id=self.request.user.id)
            #convert
            carty = str(self.cart)
            carty = carty.replace("\'","\"")
            #save carty to profile model
            current_user.update(old_cart=str(carty))
    
    def add(self, product, quantity):
        product_id = str(product.id)
        product_qty = str(quantity)
        
        #logic 
        if product_id in self.cart:
            pass
        else:
            #self.cart[product_id] = {'price': str(product.price)}
            self.cart[product_id] = int(product_qty)
        self.session.modified = True
        
        #duel with login in user
        if self.request.user.is_authenticated:
            #get the current user profile
            current_user = Profile.objects.filter(user__id=self.request.user.id)
            #convert
            carty = str(self.cart)
            carty = carty.replace("\'","\"")
            #save carty to profile model
            current_user.update(old_cart=str(carty))
        
    def cart_total(self):
        #get prods id
        product_ids = self.cart.keys()
        # lookup keys in db
        products = Product.objects.filter(id__in=product_ids)
        #get quantity
        quantities = self.cart
        #start count at 0
        total = 0
        for key, value in quantities.items():
            #convert key str to ...
            key = int(key)
            for product in products:
                if product.id == key:
                    if product.is_sale:
                        total = total + (product.sale_price * value)
                    else:
                        total = total + (product.price * value)
        return total
            
             
    
        
    def __len__(self):
        return len(self.cart)    
    
    def get_prods(self):
        #get id from cart
        product_ids = self.cart.keys()

        #use ids to lookup prods in db
        products = Product.objects.filter(id__in = product_ids)

        #return those looked up prods
        return products
    
    def get_quants(self):
        quantities = self.cart
        return quantities
    
    def update(self, product, quantity):
        product_id = str(product)
        product_qty = int(quantity)
        
        #get cart
        ourcart = self.cart
        #update cart
        ourcart[product_id] = product_qty
        
        self.session.modified = True
        
        if self.request.user.is_authenticated:
            #get the current user profile
            current_user = Profile.objects.filter(user__id=self.request.user.id)
            #convert
            carty = str(self.cart)
            carty = carty.replace("\'","\"")
            #save carty to profile model
            current_user.update(old_cart=str(carty))
        
        thing = self.cart
        return thing
    
    def delete(self, product):
        product_id = str(product)
        #dlt for dict/cart
        if product_id in self.cart:
            del self.cart[product_id]
            
        self.session.modified = True
        
        if self.request.user.is_authenticated:
            #get the current user profile
            current_user = Profile.objects.filter(user__id=self.request.user.id)
            #convert
            carty = str(self.cart)
            carty = carty.replace("\'","\"")
            #save carty to profile model
            current_user.update(old_cart=str(carty))
        
    