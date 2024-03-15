/**
 * This interface defines the methods for creating, validating, destroying, activating, and passivating objects of type T.
 * Implementations of this interface should provide a concrete implementation for each method.
 */
public interface ObjectFactory<T> {

    /**
     * Creates a new object of type T.
     * This method should allocate and initialize any resources necessary for the object.
     *
     * @return a new object of type T
     * @throws ObjectCreationException if there is an error creating the object
     */
    T create() throws ObjectCreationException;

    /**
     * Validates the given object of type T.
     * This method should check whether the object is in a valid state and meets any necessary conditions.
     *
     * @param object the object to validate
     * @return true if the object is valid, false otherwise
     * @throws ObjectValidationException if there is an error validating the object
     */
    boolean validate(T object) throws ObjectValidationException;

    /**
     * Destroys the given object of type T.
     * This method should release any resources allocated by the create() method for the object.
     *
     * @param object the object to destroy
     * @throws ObjectDestructionException if there is an error destroying the object
     */
    void destroy(T object) throws ObjectDestructionException;

    /**
     * Activates the given object of type T.
     * This method should make the object ready for use, for example by initializing any necessary state.
     *
     * @param object the object to activate
     * @throws ObjectActivationException if there is an error activating the object
     */
    void activate(T object) throws ObjectActivationException;

    /**
     * Passivates the given object of type T.
     * This method should make the object no longer ready for use, for example by clearing any state.
     *
     * @param object the object to passivate
     * @throws ObjectPassivationException if there is an error passivating the object
     */
    void passivate(T object) throws ObjectPassivationException;
}

// Exception classes for each method
class ObjectCreationException extends Exception {
    public ObjectCreationException(String message) {
        super(message);
    }
}

class ObjectValidationException extends Exception {
    public ObjectValidationException(String message) {
        super(message);
    }
}

class ObjectDestructionException extends Exception {
    public ObjectDestructionException(String message) {
        super(message);
    }
}

class ObjectActivationException extends Exception
